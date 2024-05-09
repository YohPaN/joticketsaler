<?php

use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProfileController;
use App\Models\Offer;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
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
    ]);
})->name('welcome');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin', function () {
    if(Gate::allows('access-admin')) {
        return Inertia::render('Admin', [
            'offers' => Offer::all()
        ]);
    }
    abort(403);
});

Route::post('offer', [OfferController::class, 'store'])->name('offer.store');
Route::put('offer', [OfferController::class, 'update'])->name('offer.update');
Route::delete('offer/{id}', [OfferController::class, 'destroy'])->name('offer.delete');

Route::get('shop', function() {
    return Inertia::render('Shop', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'offers' => Offer::all()->select('id', 'name', 'price', 'ticket_number')->sortBy('ticket_number'),
    ]);
})->middleware(['auth', 'verified'])->name('shop');

require __DIR__.'/auth.php';
