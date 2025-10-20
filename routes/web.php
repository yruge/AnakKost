<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;

Route::get('welcome', function () {
    return view('welcome');
});

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboards');
})->middleware('auth')->name('dashboard');