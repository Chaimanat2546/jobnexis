<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EducationProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompaniesProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileDetailController;
use App\Http\Controllers\CertificateController;

Route::get('/', fn() => view('welcome'))->name('/');

Route::middleware(['auth', 'verified'])->group(function () {

    /** ---------------- Dashboard ---------------- */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/edit-provider/{userId?}', [CompaniesProfileController::class, 'edit'])
        ->name('provider.profile.edit');
    Route::post('/edit-provider/{userId?}/store', [CompaniesProfileController::class, 'store'])
        ->name('provider.profile.store');
    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/providers', [CompaniesProfileController::class, 'index'])
            ->name('admin.providers.index');
        Route::patch('/admin/providers/{user}/toggle-ban', [CompaniesProfileController::class, 'toggleBan'])
            ->name('admin.providers.toggleBan');
        Route::delete('/admin/providers/{user}', [CompaniesProfileController::class, 'destroy'])
            ->name('admin.providers.destroy');
    });

    /** ---------------- Profile Details ---------------- */
    Route::prefix('admin/profile')->group(function () {
        Route::delete('/education/{id}', [ProfileDetailController::class, 'destroyEducation'])->name('education.destroy');
        Route::delete('/work/{id}', [ProfileDetailController::class, 'destroyWork'])->name('work.destroy');
    });
    Route::patch('/certificates/{id}/toggle', [CertificateController::class, 'toggle'])->name('certificates.toggle');
    Route::delete('/certificates/{id}', [CertificateController::class, 'destroy'])->name('certificates.destroy');
    /** ---------------- Admin Routes ---------------- */
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'userStats'])
        ->name('admin.userStats');
    Route::get('/dashboard/data', [AdminDashboardController::class, 'userStatsData'])
        ->name('admin.userStats.data');

        Route::get('/jobber', [ProfileDetailController::class, 'index'])->name('admin.jobber.index');
        Route::get('/education', [EducationProfileController::class, 'index'])->name('admin.educations.index');
        Route::post('/edit-jobber/{userId}/certificate', [CertificateController::class, 'store'])
            ->name('admin.certificates.store');
        Route::get('/edit-jobber/{userId?}', [ProfileDetailController::class, 'edit'])->name('profile-details.edit');
        Route::post('/edit-jobber/{userId?}/store', [ProfileDetailController::class, 'store'])->name('profile-details.store');
        Route::get('/edit-education/{userId?}', [EducationProfileController::class, 'edit'])
            ->name('admin.profile-education.edit');
        Route::post('/edit-education/{userId?}/store', [EducationProfileController::class, 'store'])
            ->name('admin.profile-education.store');
        Route::patch('/educations/{user}/toggle-ban', [EducationProfileController::class, 'toggleBan'])
            ->name('admin.educations.toggleBan');
        Route::delete('/educations/{user}', [EducationProfileController::class, 'destroy'])
            ->name('admin.educations.destroy');
        Route::patch('/jobber/{user}/toggle-ban', [ProfileDetailController::class, 'toggleBan'])
            ->name('admin.jobber.toggleBan');
        Route::delete('/jobber/{user}', [ProfileDetailController::class, 'destroy'])
            ->name('admin.jobber.destroy');
    });

    /** ---------------- Provider Routes ---------------- */
    Route::middleware('role:provider')->prefix('provider')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'provider'])->name('provider.dashboard');
    });

    /** ---------------- Education Routes ---------------- */
    Route::middleware('role:education')->prefix('education')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'education'])->name('education.dashboard');
        Route::get('/edit-education', [EducationProfileController::class, 'edit'])
            ->name('profile-education.edit');
        Route::post('/edit-education/store', [EducationProfileController::class, 'store'])
            ->name('profile-education.store');
    });

    /** ---------------- Jobber Routes ---------------- */
    Route::middleware('role:jobber')->prefix('jobber')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'jobber'])->name('jobber.dashboard');
        Route::post('/jobber/edit-profile/certificate', [CertificateController::class, 'store'])->name('certificates.store');
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
