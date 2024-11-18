<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{MemberController, EventController, RegistrationController, LeaderboardController, DiscussionController, LearningMaterialController, CertificateController, AdminController};

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Member Routes
Route::middleware(['auth:sanctum', 'verified', 'approved'])->group(function () {
    Route::get('/dashboard', [MemberController::class, 'index'])->name('dashboard');
    Route::resource('events', EventController::class);
    Route::resource('leaderboards', LeaderboardController::class);
    Route::resource('discussions', DiscussionController::class);
    Route::resource('learning-materials', LearningMaterialController::class);
    Route::resource('certificates', CertificateController::class);
    Route::post('register-event/{id}', [RegistrationController::class, 'store'])->name('register.event');
});

Route::middleware(['auth:sanctum', 'verified', 'role:admin', 'approved'])->group(function () {
    Route::resource('admin/events', AdminController::class);
    Route::resource('admin/members', AdminController::class);
    Route::post('/admin/approve-user/{id}', [AdminController::class, 'approveUser'])->name('admin.approve-user');
});

