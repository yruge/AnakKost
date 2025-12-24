<?php

use App\Http\Controllers\TenantDashboardController;
use App\Http\Controllers\TenantRegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserRegistrationController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();

        if ($user && isset($user->tenant) && $user->tenant && $user->tenant->room_id) {
            return redirect()->route('tenant.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    return view('landing');
})->name('home');

Route::get('welcome', function () {
    return view('welcome');
});

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/user/dashboard', [UserDashboardController::class, 'index']) ->middleware('auth', 'not.tenant') ->name('user.dashboard');

Route::get('/owner/dashboard', [\App\Http\Controllers\OwnerDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('owner.dashboard');

Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/rooms', [\App\Http\Controllers\RoomManagementController::class, 'index'])->name('rooms.index');
    Route::post('/rooms', [\App\Http\Controllers\RoomManagementController::class, 'store'])->name('rooms.store');
    Route::put('/rooms/{room}', [\App\Http\Controllers\RoomManagementController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [\App\Http\Controllers\RoomManagementController::class, 'destroy'])->name('rooms.destroy');

    Route::get('/tenants', [\App\Http\Controllers\TenantManagementController::class, 'index'])->name('tenants.index');
    Route::post('/tenants', [\App\Http\Controllers\TenantManagementController::class, 'store'])->name('tenants.store');
    Route::put('/tenants/{tenant}', [\App\Http\Controllers\TenantManagementController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{tenant}', [\App\Http\Controllers\TenantManagementController::class, 'destroy'])->name('tenants.destroy');

    Route::get('/payments', [\App\Http\Controllers\PaymentManagementController::class, 'index'])->name('payments.index');
    Route::post('/payments', [\App\Http\Controllers\PaymentManagementController::class, 'store'])->name('payments.store');
    Route::put('/payments/{payment}', [\App\Http\Controllers\PaymentManagementController::class, 'update'])->name('payments.update');
    Route::delete('/payments/{payment}', [\App\Http\Controllers\PaymentManagementController::class, 'destroy'])->name('payments.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/tenant/dashboard', [TenantDashboardController::class, 'index'])->name('tenant.dashboard');

    Route::post('/tenant', [TenantRegistrationController::class, 'store'])->middleware('auth')->name('tenant.store');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
});

Route::get('/register-user', [UserRegistrationController::class, 'showForm'])
    ->name('user.register');

Route::post('/register-user', [UserRegistrationController::class, 'store'])
    ->name('user.register.store');
