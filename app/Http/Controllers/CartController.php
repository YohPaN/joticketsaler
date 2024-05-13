<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use stdClass;

class CartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart = Auth::user()->cart;

        if($cart !== null) {
            $items = json_decode($cart->items);

            if($items === null) {
                $items = [];
            }

            $find = false;
            foreach ($items as $item) {
                if($item->offer_id === $request->id) {
                    $item->count ++;
                    $find = true;
                    break;
                }
            }

            if(!$find) {
                $item = new stdClass();
                $item->count = 1;
                $item->offer_id = $request->id;
                array_push($items, $item);
            }

            $cart->update([
                'items' => $items,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

        $cart = Auth::user()->cart;
        $items = json_decode($cart->items);
        $data = [];

        if($items !== null) {
            foreach ($items as $item) {
                $offer = Offer::select('id', 'name', 'price', 'ticket_number')->find($item->offer_id);
                $offer->count = $item->count;
                array_push($data, $offer);
            }
        }

        return Inertia::render('Cart', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Auth::user()->cart;
        $items = json_decode($cart->items);

        for ($i=0; $i < count($items); $i++) {
            if($items[$i]->offer_id == $id) {
                array_splice($items, $i, 1);

                $cart->update([
                    'items' => json_encode($items),
                ]);
                break;
            }
        }
    }
}
