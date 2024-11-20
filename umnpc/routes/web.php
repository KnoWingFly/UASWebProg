<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDash;

// Welcome Route
Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Not Approved Route (without 'auth' middleware)
Route::get('/not-approved', [AuthController::class, 'notApproved'])->name('not-approved');

// Authenticated and Approved Routes
Route::middleware(['auth', 'approve'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('user.dashboard');
    
    // Admin-specific Routes
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDash::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminDash::class, 'manageUsers'])->name('admin.users');
        Route::get('/approvals', [AdminDash::class, 'userApprovals'])->name('admin.approvals');
        Route::get('/settings', [AdminDash::class, 'settings'])->name('admin.settings');
        Route::post('/users/{user}/approve', [AdminDash::class, 'approveUser'])->name('admin.users.approve');
    });
});

// Fallback Route for undefined paths
Route::fallback([AuthController::class, 'fallback']);