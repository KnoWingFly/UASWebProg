<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDash;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\LearningMaterialController as AdminLearningMaterialController;
use App\Http\Controllers\Admin\MaterialCategoryController as AdminMaterialCategoryController;
use App\Http\Controllers\User\LearningMaterialController as UserLearningMaterialController;
use App\Http\Controllers\User\MaterialCategoryController as UserMaterialCategoryController;

// ============================= Public Routes =============================
Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/not-approved', [AuthController::class, 'notApproved'])->name('not-approved');

// ============================= Authenticated Routes =============================
Route::middleware(['auth', 'approve'])->group(function () {

    // ========================= User-Specific Routes =========================
    Route::prefix('user')->name('user.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

        // Events
        Route::get('/events', [UserController::class, 'events'])->name('events');
        Route::get('/event/details/{event_id}', [UserController::class, 'eventdetails'])->name('event.details');
        Route::post('/events/{event}/participate', [UserController::class, 'participate'])->name('events.participate');
        Route::get('/register_event/{id}', [UserController::class, 'registerEvent'])->name('register_event');
        Route::delete('/events/{event}/cancel-registration', [UserController::class, 'cancelRegistration'])->name('cancel_registration');

        // Learning Materials
        Route::prefix('materials')->name('materials.')->group(function () {
            Route::get('/', [UserLearningMaterialController::class, 'index'])->name('index');
            Route::get('/{material}', [UserLearningMaterialController::class, 'show'])->name('show');
            Route::get('/{material}/download', [UserLearningMaterialController::class, 'download'])->name('download');
        });

        // Profile
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');

        // Categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [UserMaterialCategoryController::class, 'index'])->name('index');
            Route::get('/{category}', [UserMaterialCategoryController::class, 'show'])->name('show');
        });

        Route::prefix('materials')->name('materials.')->group(function () {
            Route::get('/{material}/download', [UserLearningMaterialController::class, 'download'])->name('download');
            Route::get('/{material}/view', [UserLearningMaterialController::class, 'show'])->name('view');
        });
        Route::resource('materials', UserLearningMaterialController::class);
    });

    // ========================= Admin-Specific Routes =========================
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDash::class, 'index'])->name('dashboard');

        // Manage Users
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/manage', [AdminDash::class, 'manageUsers'])->name('manage');
            Route::put('/{user}', [AdminDash::class, 'update'])->name('update');
            Route::delete('/{user}', [AdminDash::class, 'deleteUser'])->name('destroy');

            // Bulk Operations
            Route::post('/bulk-approve', [AdminDash::class, 'bulkApprove'])->name('bulk-approve');
            Route::post('/bulk-delete', [AdminDash::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/bulk-disapprove', [AdminDash::class, 'bulkDisapprove'])->name('bulk-disapprove');
        });

        // Approvals
        Route::get('/approvals', [AdminDash::class, 'userApprovals'])->name('approvals');
        Route::post('/approvals/{user}/approve', [AdminDash::class, 'approveUser'])->name('users.approve');

        // Events
        Route::prefix('events')->name('events.')->group(function () {
            Route::get('/', [AdminDash::class, 'indexEvents'])->name('index');
            Route::get('/create', [AdminDash::class, 'createEvent'])->name('create');
            Route::post('/', [AdminDash::class, 'storeEvent'])->name('store');
            Route::get('/{event}/edit', [AdminDash::class, 'editEvent'])->name('edit');
            Route::put('/{event}', [AdminDash::class, 'updateEvent'])->name('update');
            Route::delete('/{event}', [AdminDash::class, 'deleteEvent'])->name('destroy');
            Route::get('/{event}/participants', [AdminDash::class, 'participants'])->name('participants');
            Route::delete('/{event}/participants/{participant}', [AdminDash::class, 'removeParticipant'])->name('removeParticipant');
        });

        // Categories
        Route::resource('categories', AdminMaterialCategoryController::class)->except('show');
        Route::get('/categories/{category}', [AdminMaterialCategoryController::class, 'show'])->name('categories.show');

        // Learning Materials
        Route::prefix('materials')->name('materials.')->group(function () {
            Route::get('/{material}/download', [AdminLearningMaterialController::class, 'download'])->name('download');
            Route::get('/{material}/view', [AdminLearningMaterialController::class, 'show'])->name('view');
        });
        Route::resource('materials', AdminLearningMaterialController::class);

        // Settings
        Route::get('/settings', [AdminDash::class, 'settings'])->name('settings');
    });
});

// ============================= Fallback Route =============================
Route::fallback([AuthController::class, 'fallback']);
