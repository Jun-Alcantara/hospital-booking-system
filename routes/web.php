<?php

use App\Http\Controllers\BookingFormControllerX;
use App\Http\Controllers\FrontEnd\BookingFormController;
use App\Http\Controllers\BookingDashboardController;
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

Route::get('/', [BookingFormController::class, 'index']);

Route::group(['prefix' => 'console'], function () {
    Route::get('dashboard', [BookingDashboardController::class, 'index']);
});

Route::get('/', [BookingFormControllerX::class, 'index']);
Route::post('/booking/submit', [BookingFormController::class, 'submit']);
Route::get('/booking/status/{booking}', [BookingFormController::class, 'showStatus'])->name('booking.status');
