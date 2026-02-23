<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    
    // Profile routes (available for all authenticated users)
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // Owner routes
    Route::middleware('role:pemilik')->group(function () {
        Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
        Route::get('/owner/motors', [OwnerController::class, 'motors'])->name('owner.motors');
        Route::get('/owner/create-motor', [OwnerController::class, 'createMotor'])->name('owner.create-motor');
        Route::post('/owner/store-motor', [OwnerController::class, 'storeMotor'])->name('owner.store-motor');
        Route::get('/owner/revenue', [OwnerController::class, 'revenue'])->name('owner.revenue');
        Route::get('/owner/revenue/pdf', [OwnerController::class, 'downloadRevenuePdf'])->name('owner.revenue.pdf');
        
        // Motor CRUD operations
        Route::get('/owner/motor/{id}', [OwnerController::class, 'showMotor'])->name('owner.show-motor');
        Route::get('/owner/motor/{id}/edit', [OwnerController::class, 'editMotor'])->name('owner.edit-motor');
        Route::put('/owner/motor/{id}', [OwnerController::class, 'updateMotor'])->name('owner.update-motor');
        Route::delete('/owner/motor/{id}', [OwnerController::class, 'deleteMotor'])->name('owner.delete-motor');
        Route::patch('/owner/motor/{id}/maintenance', [OwnerController::class, 'setMaintenance'])->name('owner.set-maintenance');
        Route::get('/owner/motor/{id}/details', [OwnerController::class, 'getMotorDetails'])->name('owner.motor.details');
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
        Route::get('/renter/rental/{id}/details', [App\Http\Controllers\RenterController::class, 'getRentalDetails'])->name('renter.rental.details');
        Route::get('/renter/rental/{id}/download-invoice', [App\Http\Controllers\RenterController::class, 'downloadInvoice'])->name('renter.rental.download-invoice');
    });
    
    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/motor-verification', [AdminController::class, 'motorVerification'])->name('admin.motor-verification');
        Route::get('/admin/motor-verification/{id}', [AdminController::class, 'motorVerificationDetail'])->name('admin.motor-verification.detail');
        Route::post('/admin/verify-motor/{id}', [AdminController::class, 'verifyMotor'])->name('admin.verify-motor');
        Route::get('/admin/rental-management', [AdminController::class, 'rentalManagement'])->name('admin.rental-management');
        Route::post('/admin/confirm-payment/{id}', [AdminController::class, 'confirmPayment'])->name('admin.confirm-payment');
        Route::post('/admin/confirm-return/{id}', [AdminController::class, 'confirmReturn'])->name('admin.confirm-return');
        Route::get('/admin/report', function() {
            return view('admin.reports-react');
        })->name('admin.report');
        Route::get('/admin/api/reports', [AdminController::class, 'getReportData'])->name('admin.api.reports');
        Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/admin/reports/export', [AdminController::class, 'exportReportsData'])->name('admin.reports.export');
        Route::get('/admin/rental/{id}/payment-proof', [AdminController::class, 'getPaymentProof'])->name('admin.rental.payment-proof');
        Route::get('/admin/rental/{id}/details', [AdminController::class, 'getRentalDetails'])->name('admin.rental.details');
        Route::get('/admin/rental/{id}/export-pdf', [AdminController::class, 'exportRentalPdf'])->name('admin.rental.export-pdf');
        Route::get('/admin/revenue-summary', [AdminController::class, 'revenueSummary'])->name('admin.revenue-summary');
        Route::get('/admin/motor/{id}/details', [AdminController::class, 'getMotorDetails'])->name('admin.motor.details');
        
        // Transaction Report
        Route::get('/admin/transaction-report', [AdminController::class, 'transactionReport'])->name('admin.transaction-report');
        
        // Tarif Rental Management
        Route::get('/admin/tarif-rental', [AdminController::class, 'tarifRental'])->name('admin.tarif-rental');
        Route::post('/admin/tarif-rental/{id}/update', [AdminController::class, 'updateTarif'])->name('admin.tarif-rental.update');
        
        // User Management
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::post('/admin/users/{id}/toggle-block', [AdminController::class, 'toggleBlockUser'])->name('admin.users.toggle-block');
    });
    
});
