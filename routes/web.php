<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UploadController;

require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'index'])
    ->name('dashboard');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/hotels', [TeamController::class, 'index'])
        ->name('hotels.index');
    Route::get('/hotels/{hotel}', [TeamController::class, 'show'])
        ->name('hotels.show');
    Route::get('/hotels/{hotel}/branches/{branch}/rooms/{room}', [RoomController::class, 'show'])
        ->name('rooms.show');
});

Route::post('rooms/{room}/booking', [BookingController::class, 'store'])
    ->middleware('auth')
    ->name('bookings.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/history', [BookingController::class, 'history'])
        ->name('bookings.history');
    Route::delete('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
        ->name('bookings.cancel');
    Route::post('/bookings/{booking}/checkin', [BookingController::class, 'checkIn'])
        ->name('bookings.checkin');
    Route::get('/bookings/history/detail/{booking}', [BookingController::class, 'detail'])
        ->name('booking.detail');
    Route::get('/bookings/history/detail/{booking}/invoice/pdf', [BookingController::class, 'downloadInvoicePdf'])
        ->name('bookings.invoice.pdf');
    Route::get('/bookings/history/detail/{booking}/send-confirmation', [BookingController::class, 'sendConfirmation'])
        ->name('bookings.sendConfirmation');
});

Route::match(['get', 'post'], '/payments/{booking}/process', [PaymentController::class, 'processPayment'])
    ->name('payments.process');

Route::middleware(['auth'])->group(function () {
    Route::get('payment/vnpay/return', [PaymentController::class, 'handleReturn'])->name('vnpay.return');
    Route::get('/payment/success/', [PaymentController::class, 'success'])
        ->name('payment.success');
    Route::get('/payment/failed/', [PaymentController::class, 'failed'])
        ->name('payment.failed');
});

Route::post('/upload', [UploadController::class, 'upload']);
