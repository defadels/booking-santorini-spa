<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TherapistController as AdminTherapistController;
use App\Http\Controllers\Admin\TreatmentController as AdminTreatmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpaController;
use Illuminate\Support\Facades\Route;

// Public Website Routes
Route::get('/', [SpaController::class, 'index'])->name('home');
Route::get('/treatments/{slug}', [SpaController::class, 'show'])->name('treatments.show');

// Customer Booking Routes (Login Required)
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/booking/{slug}', [SpaController::class, 'bookingForm'])->name('booking.form');
    Route::post('/booking/{slug}', [SpaController::class, 'storeBooking'])->name('booking.store');
    Route::get('/booking/confirmation/{booking_code}', [SpaController::class, 'confirmation'])->name('booking.confirmation');
});

// Redirect dashboard dynamically based on role
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('customer.dashboard');
})->middleware(['auth'])->name('dashboard');

// Customer Panel Routes
Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\CustomerController::class, 'dashboard'])->name('dashboard');
    Route::post('/profile/update', [\App\Http\Controllers\CustomerController::class, 'updateProfile'])->name('profile.update');
    Route::post('/password/update', [\App\Http\Controllers\CustomerController::class, 'updatePassword'])->name('password.update');
    Route::post('/bookings/{id}/cancel', [\App\Http\Controllers\CustomerController::class, 'cancelBooking'])->name('bookings.cancel');
});

// Admin Panel Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola Booking
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{id}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');

    // Manajemen Terapis
    Route::get('/therapists', [AdminTherapistController::class, 'index'])->name('therapists.index');
    Route::post('/therapists', [AdminTherapistController::class, 'store'])->name('therapists.store');
    Route::post('/therapists/{id}/update', [AdminTherapistController::class, 'update'])->name('therapists.update');
    Route::delete('/therapists/{id}', [AdminTherapistController::class, 'destroy'])->name('therapists.destroy');

    // Manajemen Treatment
    Route::get('/treatments', [AdminTreatmentController::class, 'index'])->name('treatments.index');
    Route::post('/treatments', [AdminTreatmentController::class, 'store'])->name('treatments.store');
    Route::post('/treatments/{id}/update', [AdminTreatmentController::class, 'update'])->name('treatments.update');
});

// Profile Management (Breeze default)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
