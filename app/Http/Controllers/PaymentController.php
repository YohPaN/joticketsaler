<?php

namespace App\Http\Controllers;

use App\Services\TicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    /**
     * Display payment interface.
     */
    public function index(): Response
    {
        return Inertia::render('Payment', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    /**
     * Process a checkout and redirect the user.
     */
    public function checkout(Request $request): RedirectResponse
    {

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

        return redirect()->back();
    }
}
