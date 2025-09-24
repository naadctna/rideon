<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    
    // Owner routes
    Route::middleware('role:pemilik')->group(function () {
        Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
        Route::get('/owner/create-motor', [OwnerController::class, 'createMotor'])->name('owner.create-motor');
        Route::post('/owner/store-motor', [OwnerController::class, 'storeMotor'])->name('owner.store-motor');
        Route::get('/owner/revenue', [OwnerController::class, 'revenue'])->name('owner.revenue');
        
        // Motor CRUD operations
        Route::get('/owner/motor/{id}', [OwnerController::class, 'showMotor'])->name('owner.show-motor');
        Route::get('/owner/motor/{id}/edit', [OwnerController::class, 'editMotor'])->name('owner.edit-motor');
        Route::put('/owner/motor/{id}', [OwnerController::class, 'updateMotor'])->name('owner.update-motor');
        Route::delete('/owner/motor/{id}', [OwnerController::class, 'deleteMotor'])->name('owner.delete-motor');
        Route::patch('/owner/motor/{id}/maintenance', [OwnerController::class, 'setMaintenance'])->name('owner.set-maintenance');
    });
    
    // Renter routes
    Route::middleware('role:penyewa')->group(function () {
        Route::get('/renter/dashboard', [App\Http\Controllers\RenterController::class, 'dashboard'])->name('renter.dashboard');
        Route::post('/renter/filter-motors', [App\Http\Controllers\RenterController::class, 'filterMotors'])->name('renter.filter-motors');
        Route::get('/renter/search', [App\Http\Controllers\RenterController::class, 'searchMotors'])->name('renter.search');
        Route::get('/renter/motor/{id}', [App\Http\Controllers\RenterController::class, 'showMotor'])->name('renter.show-motor');
        Route::post('/renter/motor/{id}/rent', [App\Http\Controllers\RenterController::class, 'rentMotor'])->name('renter.rent-motor');
        Route::post('/renter/booking', [App\Http\Controllers\RenterController::class, 'storeBooking'])->name('renter.store-booking');
        Route::get('/renter/payment/{transactionId}', [App\Http\Controllers\RenterController::class, 'payment'])->name('renter.payment');
        Route::get('/renter/my-rentals', [App\Http\Controllers\RenterController::class, 'myRentals'])->name('renter.my-rentals');
    });
    
    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/motor-verification', [AdminController::class, 'motorVerification'])->name('admin.motor-verification');
        Route::post('/admin/verify-motor/{id}', [AdminController::class, 'verifyMotor'])->name('admin.verify-motor');
        Route::get('/admin/rental-management', [AdminController::class, 'rentalManagement'])->name('admin.rental-management');
        Route::post('/admin/confirm-payment/{id}', [AdminController::class, 'confirmPayment'])->name('admin.confirm-payment');
        Route::post('/admin/confirm-return/{id}', [AdminController::class, 'confirmReturn'])->name('admin.confirm-return');
        Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/admin/reports/export', [AdminController::class, 'exportReports'])->name('admin.reports.export');
        Route::get('/admin/rental/{id}/payment-proof', [AdminController::class, 'getPaymentProof'])->name('admin.rental.payment-proof');
        Route::get('/admin/rental/{id}/details', [AdminController::class, 'getRentalDetails'])->name('admin.rental.details');
    });
    
});
