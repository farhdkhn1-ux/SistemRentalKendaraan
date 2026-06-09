<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RentalController;

Route::middleware(['auth'])->group(function () {
    Route::resource('vehicles', VehicleController::class);
    Route::resource('rentals', RentalController::class);
});