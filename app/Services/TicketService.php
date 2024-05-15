<?php

namespace App\Services;

use App\Mail\TicketMail;
use App\Models\Offer;
use App\Models\Ticket;
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
}
