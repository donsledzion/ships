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

Route::get('/',[\App\Http\Controllers\HomeController::class,'index'] )->middleware('online');

Auth::routes();

Route::resource('table',TableController::class)->middleware(['auth','online']);
Route::get('/table/{table}/lobby',[TableController::class,'lobby'])->name('table.lobby')->middleware(['auth','online']);


Route::resource('board', BoardController::class)->middleware(['auth','online']);
Route::get('/user/{id}',[UserController::class,'show'])->name('user.show')->middleware(['auth','online']);
Route::get('/users',[UserController::class,'index'])->name('user.index')->middleware(['auth','online']);
Route::get('/user/{id}/online-status',[UserController::class,'online'])->name('user.online')->middleware(['auth','online']);


Route::post('/board/{board}/shot/{string}/{int}',[BoardController::class,'shot'])->middleware(['auth','online']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('online');

Route::get('/error/{string?}',[\App\Http\Controllers\ErrorController::class,'show'])->name('error');
;
