<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::middleware((['auth', 'verified']))->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/edit-jobber', [CertificateController::class, 'index'])->name('certificates.index');
    Route::post('/admin/edit-jobber', [CertificateController::class, 'store'])->name('certificates.store');
    Route::patch('/admin/edit-jobber/{id}/toggle', [CertificateController::class, 'toggle'])->name('certificates.toggle');
    Route::delete('/admin/edit-jobber/{id}', [CertificateController::class, 'destroy'])->name('certificates.destroy');

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/jobber', [UserController::class, 'index']);
        Route::get('/admin/provider', [UserController::class, 'indexProvider']);
        Route::get('/admin/education', [UserController::class, 'indexEducation']);
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
