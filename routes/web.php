<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileDetailController;
use App\Http\Controllers\CertificateController;

Route::get('/', fn () => view('welcome'))->name('/');

Route::middleware(['auth', 'verified'])->group(function () {

    /** ---------------- Dashboard ---------------- */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /** ---------------- Certificate ---------------- */
    Route::prefix('admin/edit-jobber')->group(function () {
        Route::get('/', [CertificateController::class, 'index'])->name('certificates.index');
        Route::post('/certificate', [CertificateController::class, 'store'])->name('certificates.store');
        Route::patch('/certificate/{id}/toggle', [CertificateController::class, 'toggle'])->name('certificates.toggle');
    });

    /** ---------------- Profile Details ---------------- */
    Route::prefix('admin/profile')->group(function () {
        Route::delete('/education/{id}', [ProfileDetailController::class, 'destroyEducation'])->name('education.destroy');
        Route::delete('/work/{id}', [ProfileDetailController::class, 'destroyWork'])->name('work.destroy');
    });

    /** ---------------- Admin Routes ---------------- */
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/jobber', [UserController::class, 'index']);
        Route::get('/provider', [UserController::class, 'indexProvider']);
        Route::get('/education', [UserController::class, 'indexEducation']);

        Route::get('/edit-jobber/{userId?}', [ProfileDetailController::class, 'edit'])->name('profile-details.edit');
        Route::post('/edit-jobber/{userId?}/store', [ProfileDetailController::class, 'store'])->name('profile-details.store');
    });

    /** ---------------- Provider Routes ---------------- */
    Route::middleware('role:provider')->prefix('provider')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'provider'])->name('provider.dashboard');
    });

    /** ---------------- Education Routes ---------------- */
    Route::middleware('role:education')->prefix('education')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'education'])->name('education.dashboard');
    });

    /** ---------------- Jobber Routes ---------------- */
    Route::middleware('role:jobber')->prefix('jobber')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'jobber'])->name('jobber.dashboard');

        Route::get('/edit-profile', [ProfileDetailController::class, 'edit'])->name('profile-jobber.edit');
        Route::post('/edit-profile/store', [ProfileDetailController::class, 'store'])->name('profile-jobber.store');
    });

    /** ---------------- User Profile ---------------- */
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';
