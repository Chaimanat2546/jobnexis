<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware((['auth', 'verified']))->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    });

    // Provider routes
    Route::middleware('role:provider')->group(function () {
        Route::get('/provider/dashboard', [DashboardController::class, 'provider'])->name('provider.dashboard');
    });

    // Education routes
    Route::middleware('role:education')->group(function () {
        Route::get('/education/dashboard', [DashboardController::class, 'education'])->name('education.dashboard');
    });

    // Jober routes
    Route::middleware('role:jobber')->group(function () {
        Route::get('/jobber/dashboard', [DashboardController::class, 'jobber'])->name('jobber.dashboard');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
