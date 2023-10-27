<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ruta', function () {   return "H0ola";});
Route::post('/ruta/post', function(){
    return "POSTA ESTA";
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/card', fn() => Response::view('/card'));
// Route::get('/card', function(){
//     return Response::view('/card');
// });


// Route::post('/card', function(Request $request){
//     dd($request->query('phone_number'));
// });

Route::post('/card', function(Request $request){
    $data = $request->all();

    // dd($data);
    DB::statement(
        "INSERT INTO contacts (name, phone_number)
        VALUES (?,?)", [$data["name"], $data["phone_number"]]
        );

    return "Contact Card stored!";
});
