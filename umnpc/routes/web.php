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

        // Manage Users
        Route::get('/manage-users', [AdminDash::class, 'manageUsers'])->name('admin.manage-users');
        Route::put('/admin/users/{user}', [AdminDash::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [AdminDash::class, 'deleteUser'])->name('admin.users.destroy');

        // Bulk Operations
        Route::post('/users/bulk-approve', [AdminDash::class, 'bulkApprove'])->name('admin.users.bulk-approve');
        Route::post('/users/bulk-delete', [AdminDash::class, 'bulkDelete'])->name('admin.users.bulk-delete');

        // Approvals
        Route::post('/approvals/{user}/approve', [AdminDash::class, 'approveUser'])->name('admin.users.approve');

        // Settings
        Route::get('/settings', [AdminDash::class, 'settings'])->name('admin.settings');
    });
});

// Fallback Route for undefined paths
Route::fallback([AuthController::class, 'fallback']);
