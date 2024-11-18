<?php

use Illuminate\Support\Facades\Route;

//controller
use App\Http\Controllers\Admin\UserApprovalController;

//middleware
use App\Http\Middleware\CheckApproval;
use App\Http\Middleware\EnsureAdmin;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/approval-notice', function () {
    return view('auth.approval-notice');
})->name('approval.notice');

// Dashboard dengan middleware auth dan approved
Route::middleware(['auth', CheckApproval::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/');
})->name('logout');

// Admin route dengan middleware auth dan admin
Route::middleware(['auth', EnsureAdmin::class])->group(function () {
    Route::get('/admin/user-approval', [UserApprovalController::class, 'index'])->name('admin.user-approval');
    Route::post('/admin/user-approval/{id}/approve', [UserApprovalController::class, 'approve'])->name('admin.approve-user');
});
