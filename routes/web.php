<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\HomeController;
use App\Models\Card;
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

Route::get('/ruta', function () {   return "H0ola";});
Route::post('/ruta/post', function(){
    return "POSTA ESTA";
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get("/contacts",[CardController::class, "index"])->name("contacts.index");
Route::get("/contacts/create",[CardController::class, "create"])->name("contacts.create");
Route::post("/contacts",[CardController::class, "store"])->name("contacts.store");
Route::get("/contacts/{card}",[CardController::class, "show"])->name("contacts.show");
Route::get("/contacts/{card}/edit",[CardController::class, "edit"])->name("contacts.edit");
Route::put("/contacts/{card}",[CardController::class, "update"])->name("contacts.update");
Route::delete("/contacts/{card}",[CardController::class, "destroy"])->name("contacts.destroy");

// Route::resource("contacts", CardController::class);
