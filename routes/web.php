<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
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
    return view('home');
});

Auth::routes();

Route::resource('table',TableController::class)->middleware('auth');
Route::get('/table/{table}/lobby',[TableController::class,'lobby'])->name('table.lobby')->middleware('auth');


Route::resource('board', BoardController::class)->middleware('auth');
Route::get('/user/{id}',[UserController::class,'show'])->name('user.show')->middleware('auth');

Route::post('/board/{board}/shot/{string}/{int}',[BoardController::class,'shot'])->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/error/{string?}',function($string=""){
    return view('error',[
        'message' => $string
    ]);
});
