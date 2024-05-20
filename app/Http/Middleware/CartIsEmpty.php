<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CartIsEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::user()->cart->items || empty(json_decode(Auth::user()->cart->items))) {
            return redirect('shop')->with('empty_cart', 'Vous ne pouvez pas accèder à cette page car votre panier est vide !');
        }
        return $next($request);
    }
}
