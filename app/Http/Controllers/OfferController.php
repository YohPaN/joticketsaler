<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OfferController extends Controller
{
    /**
     * Store a newly created offer.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|min:1|max:255|unique:offers',
            'price' => 'required|decimal:2|min:0',
            'ticket_number' => 'required|integer|min:0|max:255',
        ]);

        Offer::create([
            'name' => $request->name,
            'price' => $request->price,
            'ticket_number' => $request->ticket_number,
        ]);

        return redirect('/offer-managment');
    }

    /**
     * Update offer.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:1', 'max:255', Rule::unique('offers')->ignore($request->id)],
            'price' => 'required|decimal:2|min:0',
            'ticket_number' => 'required|integer|min:0|max:255',
        ]);

        $offer = Offer::find($request->id);

        $offer->update([
            'name' => $request->name,
            'price' => $request->price,
            'ticket_number' => $request->ticket_number,
        ]);

        return redirect('/offer-managment');
    }

    /**
     * Destroy offer.
     */
    public function destroy($id): void
    {
        Offer::destroy($id);
    }
}
