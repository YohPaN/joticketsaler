<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CartIsEmpty;
use App\Models\Offer;
use App\Services\TicketService;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'successMessage' => session('success_payment'),
    ]);
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('cart', [CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/{id}', [CartController::class, 'destroy'])->name('cart.delete');

    Route::post('checkout', [PaymentController::class, 'checkout'])->name('checkout');

    Route::get('shop', function() {
        return Inertia::render('Shop', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'offers' => Offer::all()->select('id', 'name', 'price', 'ticket_number')->sortBy('ticket_number'),
            'cartId' => Auth::user()->cart->id,
            'warningMessage' => session('empty_cart'),
        ]);
    })->name('shop');
});

Route::middleware(['auth', CartIsEmpty::class])->group(function() {
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');

    Route::get('payment', [PaymentController::class, 'index'])->name('payment');
});

Route::get('/offer-managment', function () {
    if(Gate::allows('access-admin')) {
        return Inertia::render('OfferManagment', [
            'offers' => Offer::all()
        ]);
    }
    abort(403);
})->name('offer-managment');

Route::get('/scan', function () {
    if(Gate::allows('access-admin')) {
        return Inertia::render('Scan');
    }
    abort(403);
})->name('scan');

Route::get('/docs/{url?}', function ($url="") {
    if($url === "") {
        header("Location: /docs/index.html");
        exit;
    }
    $resp = response(Storage::disk('local-docs')->get($url));
    $resp->header('content-type', MimeType::fromFilename($url));
    return $resp;
})->where('url', '(.*)');

Route::post('offer', [OfferController::class, 'store'])->name('offer.store');
Route::put('offer', [OfferController::class, 'update'])->name('offer.update');
Route::delete('offer/{id}', [OfferController::class, 'destroy'])->name('offer.delete');

Route::post('ticket-validation', function(Request $request) {
    return (new TicketService)->ticketValidation($request->ticketUserId);
})->name('ticket-validation');

require __DIR__.'/auth.php';
