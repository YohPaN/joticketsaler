<?php

namespace App\Http\Controllers;

use App\Services\TicketService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index() {
        return Inertia::render('Payment');
    }

    public function checkout(Request $request) {

        $request->card_number = str_replace(' ', '', $request->card_number);

        $request->validate([
            'card_number' => ['min:16', 'string', 'required'],
            'expiration_date' => ['required', 'date', 'after:today'],
            'cvc' => ['digits:3', 'required', 'numeric'],
        ]);

        (new TicketService)->ticketCreation();

        return redirect('/')->with('success_payment', 'Votre payement à bien été accepté !');
    }
}
