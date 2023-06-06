<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/friends', [App\Http\Controllers\HomeController::class, 'friends'])->name('friends');
Route::get('/findFriends', [App\Http\Controllers\HomeController::class, 'findFriends'])->name('findFriends');
Route::post('/findFriends', [App\Http\Controllers\HomeController::class, 'searchFriends'])->name('searchFriends');
Route::post('/show', [App\Http\Controllers\HomeController::class, 'AddFriends'])->name('AddFriends');

// map
Route::get('/map', 'App\Http\Controllers\MapController@index');
