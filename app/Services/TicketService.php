<?php

namespace App\Services;

use App\Mail\TicketMail;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TicketService
{
    public function ticketCreation()
    {
        $user = Auth::user();

        $ticket = Ticket::create([
            'scanned' => false,
            'ticket_user_id' => null,
        ]);

        $ticketUserId = $user->id.'-'.$ticket->id;

        $ticket->update([
            'ticket_user_id' => $ticketUserId,
        ]);

        DB::table('ticket_user')->insert([
            'id' => $ticketUserId,
            'user_id' => $user->id,
        ]);

        $user->cart->update([
            'items' => null,
        ]);

        Mail::to($user)->send(new TicketMail($ticket));

        return $ticket;
    }
}
