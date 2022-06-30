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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/bookings', 'BookingsController@index')->name('front.bookings.index');
Route::get('/booking-list', 'BookingsController@list')->name('front.bookings.list');

Route::prefix('admin')->middleware('auth')->group(function () {
    // Bookings
    Route::get('bookings', '\App\Http\Controllers\Admin\BookingsController@index')->name('admin.booking.index');
    Route::get('booking-list', '\App\Http\Controllers\Admin\BookingsController@list')->name('admin.booking.list');
    Route::post('bookings', '\App\Http\Controllers\Admin\BookingsController@store');
    Route::put('bookings/{booking}', '\App\Http\Controllers\Admin\BookingsController@update');
    Route::delete('bookings/{booking}', '\App\Http\Controllers\Admin\BookingsController@destroy');

    // Rooms
    Route::get('rooms', '\App\Http\Controllers\Admin\RoomsController@list')->name('admin.rooms.list');
});
