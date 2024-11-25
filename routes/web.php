<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDash;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\LearningMaterialController;
use App\Http\Controllers\Admin\MaterialCategoryController;


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
    Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('auth')->name('user.dashboard');

    // events
    Route::get('/user/events', [UserController::class, 'events'])->name('user.events');
    Route::get('/user/event/details/{event_id}', [UserController::class, 'eventdetails'])->name('user.event.details');
    Route::post('/user/events/{event}/participate', [UserController::class, 'participate'])->name('user.events.participate');
    Route::get('/user/register_event/{id}', [UserController::class, 'registerEvent'])->name('user.register_event');
    Route::delete('/events/{event}/cancel-registration', [UserController::class, 'cancelRegistration'])->name('user.cancel_registration');

    // User Learning Materials Routes
    Route::get('/user/materials', [UserController::class, 'materials'])->name('user.materials');
    Route::get('/user/materials/{material}', [UserController::class, 'showMaterial'])->name('user.materials.show');

    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');

    Route::get('/admin/materials/{material}/download', [LearningMaterialController::class, 'download'])->name('admin.materials.download');


    //================================================================ Admin routes =================================================================
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
        Route::get('/events', [AdminDash::class, 'indexEvents'])->name('admin.events.index');
        Route::get('/events/create', [AdminDash::class, 'createEvent'])->name('admin.events.create');
        Route::post('/events', [AdminDash::class, 'storeEvent'])->name('admin.events.store');
        Route::get('/events/{event}/edit', [AdminDash::class, 'editEvent'])->name('admin.events.edit');
        Route::put('/events/{event}', [AdminDash::class, 'updateEvent'])->name('admin.events.update');
        Route::delete('/events/{event}', [AdminDash::class, 'deleteEvent'])->name('admin.events.destroy');

        // Event participants
        Route::get('/admin/events/{event}/participants', [AdminDash::class, 'participants'])->name('admin.events.participants');
        Route::delete('/admin/events/{event}/participants/{participant}', [AdminDash::class, 'removeParticipant'])->name('admin.events.removeParticipant');

        // Learning Materials Routes
        Route::resource('materials', LearningMaterialController::class, ['as' => 'admin'])
            ->except(['show']);

        Route::post('/admin/materials/upload-pdf', [LearningMaterialController::class, 'uploadPdf'])
            ->name('admin.materials.upload-pdf');

        Route::post('/admin/materials/upload-video', [LearningMaterialController::class, 'uploadVideo'])
            ->name('admin.materials.upload-video');

        Route::resource('categories', MaterialCategoryController::class)
            ->names('admin.categories');

        // Settings
        Route::get('/settings', [AdminDash::class, 'settings'])->name('admin.settings');
    });
});

// Fallback Route for undefined paths
Route::fallback([AuthController::class, 'fallback']);