<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;

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

Route::get('/hotels', [TeamController::class, 'index'])
    ->name('hotels.index');
Route::get('/hotels/{hotel}', [TeamController::class, 'show'])
    ->name('hotels.show');
Route::get('/hotels/{hotel}/branches/{branch}/rooms/{room}', [RoomController::class,'show'])
    ->name('rooms.show');

Route::post('rooms/{room}/booking', [BookingController::class, 'store'])
    ->middleware('auth')
    ->name('bookings.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/history', [BookingController::class, 'history'])
        ->name('bookings.history');
});

//Route::get('rooms/{room}/book/confirmation', [BookingController::class, 'confirmation'])
//    ->name('bookings.confirmation');

Route::match(['get', 'post'], '/payments/{booking}/process', [PaymentController::class, 'processPayment'])
    ->name('payments.process');
Route::get('payment/vnpay/return', [PaymentController::class, 'handleReturn'])->name('vnpay.return');
Route::get('/payment/success/', [PaymentController::class, 'success'])
    ->name('payment.success');
Route::get('/payment/failed/', [PaymentController::class, 'failed'])
    ->name('payment.failed');
