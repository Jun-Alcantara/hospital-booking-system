<?php

use App\Http\Controllers\BookingDashboardController;
use App\Http\Controllers\BookingFormController;
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