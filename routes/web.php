<?php

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



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('suggestions', [App\Http\Controllers\FriendController::class, 'suggestion'])->name('suggestion');

Route::get('all/friend', [App\Http\Controllers\FriendController::class, 'allFriend'])->name('sent.request');
Route::post('remove/connection/{id}', [App\Http\Controllers\FriendController::class, 'removeConnection'])->name('remove.connection');


Route::get('sent/requests', [App\Http\Controllers\FriendController::class, 'sentRequests'])->name('sent.requests');
Route::post('sent/request/{id}', [App\Http\Controllers\FriendController::class, 'sentRequest'])->name('sent.request');
Route::post('withdraw/request/{id}', [App\Http\Controllers\FriendController::class, 'withdrawRequest'])->name('withdraw.request');

Route::get('recieved/request', [App\Http\Controllers\FriendController::class, 'recievedRequest'])->name('recieved.request');
Route::post('accept/request/{id}', [App\Http\Controllers\FriendController::class, 'acceptRequest'])->name('accept.request');
