<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CardShareController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\TokenController;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', fn () => auth()->check()  ? redirect("/home") : view('welcome'));

Route::get('/ruta', function () {
    return "H0ola";
});
Route::post('/ruta/post', function () {
    return "POSTA ESTA";
});

Auth::routes();

Route::middleware("auth", "subscription")->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get("/contacts", [CardController::class, "index"])->name("contacts.index");
    Route::get("/contacts/create", [CardController::class, "create"])->name("contacts.create");
    Route::post("/contacts", [CardController::class, "store"])->name("contacts.store");
    Route::get("/contacts/{card}", [CardController::class, "show"])->name("contacts.show");
    Route::get("/contacts/{card}/edit", [CardController::class, "edit"])->name("contacts.edit");
    Route::put("/contacts/{card}", [CardController::class, "update"])->name("contacts.update");
    Route::delete("/contacts/{card}", [CardController::class, "destroy"])->name("contacts.destroy");

    // Route::middleware("auth", "subscription")->resource("contacts", CardController::class);

    Route::resource("card-shares", CardShareController::class)->except(["show","edit", "update"]);
    Route::resource("tokens", TokenController::class)->only(["create","store"]);

});

Route::middleware("auth")->group(function () {

    Route::get('/sub-checkout', [StripeController::class, "subCheckout"])->name("sub-checkout");
    Route::get('/billing-portal', [StripeController::class, "billingPortal"])->name("billing-portal");
    Route::get('/free-trial-end', [StripeController::class, "freeTrialEnd"])->name("free-trial-end");
});



// Route::middleware("auth", "subscription")->
