<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\UserRegistrationController;

Route::get('welcome', function () {
    return view('welcome');
});

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboards');
})->middleware('auth')->name('dashboard');Route::get('/register-user', [UserRegistrationController::class, 'showForm'])

Route::get('/register-user', [UserRegistrationController::class, 'showForm'])
    ->name('user.register');

Route::post('/register-user', [UserRegistrationController::class, 'store'])
    ->name('user.register.store');