<?php

use Illuminate\Support\Facades\Route;

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

// home/dashboard
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// map
Route::get('/map', 'App\Http\Controllers\MapController@index');

// calendar
Route::get('/calendar', 'App\Http\Controllers\CalendarController@index');
Route::post('/calendar-event', 'App\Http\Controllers\CalendarController@calendarEvents');
Route::get('/calendar-event', 'App\Http\Controllers\CalendarController@calendarEvents');

// profile page
Route::get('/profile', 'App\Http\Controllers\ProfileController@show')->name('profile.show');
Route::put('/profile/update-username', 'App\Http\Controllers\ProfileController@updateUsername')->name('profile.update.username');
Route::put('/profile/update-password', 'App\Http\Controllers\ProfileController@updatePassword')->name('profile.update.password');
Route::delete('/profile/delete-account', 'App\Http\Controllers\ProfileController@deleteAccount')->name('profile.delete');