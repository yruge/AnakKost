<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\TenantDashboardController;
use App\Http\Controllers\TenantRegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserRegistrationController;
use App\Http\Controllers\UserDashboardController;

Route::get('welcome', function () {
    return view('welcome');
});

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/user/dashboard', [UserDashboardController::class, 'index']) ->middleware('auth', 'not.tenant') ->name('user.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/tenant/dashboard', [TenantDashboardController::class, 'index'])->name('tenant.dashboard');

    Route::post('/tenant', [TenantRegistrationController::class, 'store'])->middleware('auth')->name('tenant.store');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

    // Route::get('/booking/{room}', [BookingController::class, 'create'])->name('booking.create');
});

Route::get('/register-user', [UserRegistrationController::class, 'showForm'])
    ->name('user.register');

Route::post('/register-user', [UserRegistrationController::class, 'store'])
    ->name('user.register.store');
