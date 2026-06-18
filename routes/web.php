<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RentalController;

Route::post('/logout', function () {
    Auth::guard('web')->logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');
})->middleware('auth')->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

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