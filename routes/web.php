<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
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
   return Response::json(["message" => "hola"])->setStatusCode(404);
});

Route::get('/ch-passwd', fn() => Response::view('ch-passwd'));
// Route::get('/ch-passwd', function(Request $request){
//    return Response::view('ch-passwd');
// });

Route::post('/ch-passwd', function(Request $request){
    // if (Auth::check()){
    if (auth()->check()){
        return response("Authenticated {$request->get("password")}" );
        // return new HttpResponse("Authenticated");
    }
    else{
        return response("Not Authenticated", 401);
        // return (new HttpResponse("Not Authenticated"))->setStatusCode(401);
    }
    return "Password DETECTED?";
});
