<?php

use App\Http\Controllers\API\BookingsController;
use App\Http\Controllers\API\FullCalendarEventsController;
use App\Http\Controllers\API\PatientController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BackOffice\BookingCalendarController;
use App\Http\Controllers\BackOffice\BookingController;
use App\Http\Controllers\BackOffice\BookingSettingsController;
use App\Http\Controllers\BackOffice\ClinicController;
use App\Http\Controllers\BackOffice\ReportsController;
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
Route::get('/', [BookingFormControllerX::class, 'index']);
Route::post('booking/submit', [BookingFormController::class, 'submit']);
Route::get('booking/available-time-slots', [BookingFormController::class, 'availableTimeSlots']);
Route::get('booking/status/{booking}', [BookingFormController::class, 'showStatus'])->name('booking.status');
Route::get('booking/{booking}/health-declaration-form', [BookingFormController::class, 'showHealthDeclarationForm'])->name('booking.healthdeclarationform');
Route::post('booking/{booking}/health-declaration-form', [BookingFormController::class, 'submitHealthDeclarationForm']);

Route::get('console/login', [LoginController::class, 'show'])
    ->name('login')
    ->middleware('guest');

Route::post('console/login', [LoginController::class, 'login']);

Route::group(['prefix' => 'console', 'middleware' => ['auth']], function () {
    Route::delete('logout', [LoginController::class, 'logout'])->name('console.logout');
    Route::get('dashboard', [BookingDashboardController::class, 'index'])->name('console.dashboard');
    Route::get('settings', [BookingSettingsController::class,'showSettings'])->name('booking.settings');
    Route::post('settings', [BookingSettingsController::class, 'updateSettings'])->name('booking.settings.update');

    Route::get('booking-calendar', [BookingCalendarController::class, 'index'])->name('booking.calendar.index');

    Route::get('booking/{booking}', [BookingController::class, 'show']);
    Route::patch('booking/{booking}/approve', [BookingController::class, 'approve']);
    Route::patch('booking/{booking}/cancel', [BookingController::class, 'cancel']);
    
    Route::get('booking/{booking}/reschedule', [BookingController::class, 'rescheduleForm']);
    Route::post('booking/{booking}/reschedule', [BookingController::class, 'reschedule']);

    Route::get('reports', [ReportsController::class, 'reports']);
    Route::get('reports/server-side/patient-database', [ReportsController::class, 'downloadPatientDatabase']);

    Route::get('clinic/{clinic}/departments', [ClinicController::class, 'show']);

    // Test routes
    Route::get('booking/{booking}/send-notification', [BookingController::class, 'sendNotification']);

    Route::prefix('api')->group(function () {
        Route::get('bookings', [BookingsController::class, 'bookings']);
        Route::post('block-date', [BookingsController::class, 'blockDate']);
        Route::get('full-calendar/events', [FullCalendarEventsController::class, 'events']);
    });
});

Route::prefix('api')->group(function () {
    Route::get('patients', [PatientController::class, 'searchEmail']);
    Route::get('search/booking', [BookingsController::class, 'searchBooking']);
});
