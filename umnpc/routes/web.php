<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

// Public route
Route::get('/', function () {
    return view('welcome');
});

Route::get('/not-approved', function () {
    return view('not-approved');
})->name('not-approved');

// Routes for authenticated users (both admins and regular users)
Route::middleware(['auth', 'approval'])->group(function () {
    // Single dashboard view for both admin and user roles
    Route::get('/dashboard', function () {
        return view('dashboard'); // Pointing to views/dashboard.blade.php
    })->name('dashboard');

    // Admin-only routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users/{id}/approve', [UserController::class, 'approve'])->name('admin.users.approve');
    });
});
