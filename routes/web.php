<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {
    Auth::guard('web')->logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');
})->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::view('/profile', 'profile')
    ->middleware('auth')
    ->name('profile');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        | Dashboard
        */
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        /*
        | Vehicles CRUD
        */
        Route::resource('vehicles', VehicleController::class)
            ->except(['show']);

        /*
        | Rentals CRUD
        */
        Route::resource('rentals', RentalController::class)
            ->except(['show']);

        /*
        | Rental Actions
        */
        Route::patch('/rentals/{rental}/approve', [RentalController::class, 'approve'])
            ->name('rentals.approve');

        Route::patch('/rentals/{rental}/reject', [RentalController::class, 'reject'])
            ->name('rentals.reject');
    });

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        /*
        | View Vehicles
        */
        Route::get('/vehicles', [CustomerController::class, 'vehicles'])
            ->name('vehicles');

        /*
        | Booking Vehicle
        */
        Route::get('/booking/{vehicle}', [CustomerController::class, 'bookingForm'])
            ->name('booking');

        Route::post('/booking/{vehicle}', [CustomerController::class, 'bookingStore'])
            ->name('booking.store');

        /*
        | My Rentals
        */
        Route::get('/my-rentals', [CustomerController::class, 'myRentals'])
            ->name('my-rentals');
    });