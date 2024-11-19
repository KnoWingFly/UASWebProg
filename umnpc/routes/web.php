<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;

// Public route
Route::get('/', function () {
    return view('welcome');
});

Route::get('/not-approved', function () {
    return view('not-approved');
})->name('not-approved');

// Routes for admin-only access
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // Admin dashboard
    })->name('admin.dashboard');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{id}/approve', [UserController::class, 'approve'])->name('admin.users.approve');
});

// Routes for authenticated users (both admins and regular users)
Route::middleware(['auth', 'approval'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('user.dashboard');
    })->name('dashboard');
});
