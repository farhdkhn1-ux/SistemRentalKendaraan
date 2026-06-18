<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;


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

// Routes khusus Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('vehicles', VehicleController::class);
    Route::resource('rentals', RentalController::class);
    Route::patch('rentals/{rental}/approve', [RentalController::class, 'approve'])->name('rentals.approve');
Route::patch('rentals/{rental}/reject', [RentalController::class, 'reject'])->name('rentals.reject');
});

// Routes khusus Customer
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/vehicles', [CustomerController::class, 'vehicles'])->name('vehicles');
    Route::get('/booking/{vehicle}', [CustomerController::class, 'bookingForm'])->name('booking');
    Route::post('/booking/{vehicle}', [CustomerController::class, 'bookingStore'])->name('booking.store');
    Route::get('/my-rentals', [CustomerController::class, 'myRentals'])->name('my-rentals');
});