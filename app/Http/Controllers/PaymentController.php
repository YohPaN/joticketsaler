<?php

namespace App\Http\Controllers;

use App\Services\TicketService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index() {
        $errorMessage = null;
        if(session()->get('errors')) {
            $errorMessage = session()->get('errors')->getBag('payment_error')->first();
        }
        return Inertia::render('Payment', [
            'errorMessage' => $errorMessage,
        ]);
    }

    public function checkout(Request $request) {

        $request->card_number = str_replace(' ', '', $request->card_number);

        $request->validate([
            'card_number' => ['min:16', 'string', 'required'],
            'expiration_date' => ['required', 'date', 'after:today'],
            'cvc' => ['digits:3', 'required', 'numeric'],
        ]);

        $done = (new TicketService)->ticketCreation();

        if($done) {
            return redirect('/')->with('success_payment', 'Votre payement à bien été accepté !');
        }

        return redirect()->back()->withErrors('Une erreur est survenue !', 'payment_error');
    }
}
