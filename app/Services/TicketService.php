<?php

namespace App\Services;

use App\Mail\TicketMail;
use App\Models\Offer;
use App\Models\Ticket;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TicketService
{

    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function ticketCreation()
    {
        $items = json_decode($this->user->cart->items);
        $offers = [];

        if($items !== null) {
            foreach ($items as $item) {
                $offer = Offer::find($item->offer_id);
                $numberOfTicketInOffer = $offer->ticket_number;
                $numberOfTicketToCreate = $item->count * $numberOfTicketInOffer;
                $offers[$offer->name] = [];

                for ($i=0; $i < $numberOfTicketToCreate; $i++) {
                    array_push($offers[$offer->name], $this->ticketRegistering());
                }
            }

            try {
                Mail::to($this->user)->send(new TicketMail($offers));
            } catch (\Throwable $th) {
                throw $th;
            }

            $this->user->cart->update([
                'items' => null,
            ]);

            return true;
        }

        return false;
    }

    private function ticketRegistering()
    {
        $ticket = Ticket::create([
            'scanned' => false,
            'ticket_user_id' => null,
        ]);

        $ticketUserId = $this->user->id.'-'.$ticket->id;

        $ticket->update([
            'ticket_user_id' => $ticketUserId,
        ]);

        DB::table('ticket_user')->insert([
            'id' => $ticketUserId,
            'user_id' => $this->user->id,
        ]);

        return $ticket;
    }

    public function ticketValidation($ticketUserId)
    {
        try {
            $ticket = Ticket::where('ticket_user_id', '=', json_decode($ticketUserId)[0])->first();
            $userId = DB::table('ticket_user')->where('id', '=', $ticket->ticket_user_id)->select('user_id')->first();
            $user = User::find($userId->user_id);

            if($user->id.'-'.$ticket->id != $ticket->ticket_user_id) {
                throw new Exception('Ticket invalide');
            } elseif($ticket->scanned == 1) {
                throw new Exception('Ticket déjà scanné');
            }

            $ticket->update([
                'scanned' => true,
            ]);

            return [
                'name' => $user->name,
                'lastName' => $user->last_name,
            ];

        } catch (Exception $e) {
            if($e->getMessage() === 'Ticket déjà scanné' || $e->getMessage() === 'Ticket invalide') {
                throw new Exception($e->getMessage());
            }
            throw new Exception('Le ticket n\'a pas été trouvé');
        }
    }
}
