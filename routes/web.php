<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDash;
use App\Http\Controllers\eventcontroller;

// Welcome Route
Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Not Approved Route
Route::get('/not-approved', [AuthController::class, 'notApproved'])->name('not-approved');

// Authenticated and Approved Routes
Route::middleware(['auth', 'approve'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('user.dashboard');

    // Admin-specific Routes
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDash::class, 'index'])->name('admin.dashboard');

        // Manage Users
        Route::get('/manage-users', [AdminDash::class, 'manageUsers'])->name('admin.manage-users');
        Route::put('/users/{user}', [AdminDash::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminDash::class, 'deleteUser'])->name('admin.users.destroy');

        // Bulk Operations
        Route::post('/users/bulk-approve', [AdminDash::class, 'bulkApprove'])->name('admin.users.bulk-approve');
        Route::post('/users/bulk-delete', [AdminDash::class, 'bulkDelete'])->name('admin.users.bulk-delete');
        Route::post('/admin/users/bulk-disapprove', [AdminDash::class, 'bulkDisapprove'])->name('admin.users.bulk-disapprove');

        // Approvals
        Route::post('/approvals/{user}/approve', [AdminDash::class, 'approveUser'])->name('admin.users.approve');
        Route::get('/approvals', [AdminDash::class, 'userApprovals'])->name('admin.approvals');

        // Events
        Route::get('/admin/events', [EventController::class, 'index'])->name('admin.events.index');

        Route::get('/events', [AdminDash::class, 'indexEvents'])->name('admin.events.index');
        Route::get('/events/create', [AdminDash::class, 'createEvent'])->name('admin.events.create');
        Route::post('/events', [AdminDash::class, 'storeEvent'])->name('admin.events.store');
        Route::get('/events/{event}/edit', [AdminDash::class, 'editEvent'])->name('admin.events.edit');
        Route::put('/events/{event}', [AdminDash::class, 'updateEvent'])->name('admin.events.update');
        Route::delete('/events/{event}', [AdminDash::class, 'deleteEvent'])->name('admin.events.destroy');

        // event participants
        Route::get('/admin/events/{event}/participants', [AdminDash::class, 'participants'])->name('admin.events.participants');
        Route::delete('/admin/events/{event}/participants/{participant}', [AdminDash::class, 'removeParticipant'])->name('admin.events.removeParticipant');



        // Settings
        Route::get('/settings', [AdminDash::class, 'settings'])->name('admin.settings');
    });
});

// Fallback Route for undefined paths
Route::fallback([AuthController::class, 'fallback']);
