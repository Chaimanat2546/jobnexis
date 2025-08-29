<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CompaniesProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EducationProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Education\CourseController;
use App\Http\Controllers\Education\PersonController;
use App\Http\Controllers\Education\MediaController;
use App\Http\Controllers\Education\LessonController;
use App\Http\Controllers\ProfileDetailController;

Route::get('/', fn () => view('welcome'))->name('/');
Route::middleware(['auth', 'verified'])->group(function () {
    /** ---------------- Common Dashboard ---------------- */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /** ---------------- Shared Edit Pages (ใช้ได้ทั้ง admin และเจ้าของ role) ---------------- */
    // Provider profile (admin ใส่ {userId} ได้ / provider ไม่ใส่ก็แก้ของตัวเอง)
    Route::get('/edit-provider/{userId?}', [CompaniesProfileController::class, 'edit'])
        ->name('provider.profile.edit');
    Route::post('/edit-provider/{userId?}/store', [CompaniesProfileController::class, 'store'])
        ->name('provider.profile.store');

    // Education profile (admin ใส่ {userId} ได้ / education ไม่ใส่ก็แก้ของตัวเอง)
    Route::get('/edit-education/{userId?}', [EducationProfileController::class, 'edit'])
        ->name('admin.profile-education.edit');
    Route::post('/edit-education/{userId?}/store', [EducationProfileController::class, 'store'])
        ->name('admin.profile-education.store');

    /** ---------------- Admin-only actions under /admin/profile (คงชื่อ route เดิม) ---------------- */
    Route::prefix('admin/profile')->group(function () {
        Route::delete('/education/{id}', [ProfileDetailController::class, 'destroyEducation'])->name('education.destroy');
        Route::delete('/work/{id}', [ProfileDetailController::class, 'destroyWork'])->name('work.destroy');
    });

    /** ---------------- Certificates (ใช้ได้จากหลายบทบาท) ---------------- */
    Route::patch('/certificates/{id}/toggle', [CertificateController::class, 'toggle'])->name('certificates.toggle');
    Route::delete('/certificates/{id}', [CertificateController::class, 'destroy'])->name('certificates.destroy');

    /** ---------------- Admin Routes ---------------- */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // User stats สำหรับกราฟ/ดาต้า (แก้ให้ไม่ชน path และให้มีชื่อ route ที่ขอ)
        Route::get('/dashboard', [AdminDashboardController::class, 'userStats'])->name('userStats');
        Route::get('/user-stats/data', [AdminDashboardController::class, 'userStatsData'])->name('userStats.data');

        // จัดการ Jobber
        Route::get('/jobber', [ProfileDetailController::class, 'index'])->name('jobber.index');
        Route::patch('/jobber/{user}/toggle-ban', [ProfileDetailController::class, 'toggleBan'])->name('jobber.toggleBan');
        Route::delete('/jobber/{user}', [ProfileDetailController::class, 'destroy'])->name('jobber.destroy');

        // แก้ไขโปรไฟล์ Jobber (admin)
        Route::get('/edit-jobber/{userId?}', [ProfileDetailController::class, 'edit'])->name('profile-details.edit');
        Route::post('/edit-jobber/{userId?}/store', [ProfileDetailController::class, 'store'])->name('profile-details.store');

        // เพิ่ม Certificate ให้ผู้ใช้ (admin)
        Route::post('/edit-jobber/{userId}/certificate', [CertificateController::class, 'store'])->name('certificates.store');

        // จัดการ Provider
        Route::get('/providers', [CompaniesProfileController::class, 'index'])->name('providers.index');
        Route::patch('/providers/{user}/toggle-ban', [CompaniesProfileController::class, 'toggleBan'])->name('providers.toggleBan');
        Route::delete('/providers/{user}', [CompaniesProfileController::class, 'destroy'])->name('providers.destroy');

        // จัดการ Education
        Route::get('/education', [EducationProfileController::class, 'index'])->name('educations.index');
        Route::patch('/educations/{user}/toggle-ban', [EducationProfileController::class, 'toggleBan'])->name('educations.toggleBan');
        Route::delete('/educations/{user}', [EducationProfileController::class, 'destroy'])->name('educations.destroy');
    });


    // Education routes
    Route::middleware('role:education')->group(function () {

        // Dashboard ของ Education
        Route::get('/education/dashboard', [DashboardController::class, 'education'])->name('education.dashboard');

        // Course routes
        Route::prefix('education/courses')->name('courses.')->group(function () {
            Route::get('/', [CourseController::class, 'index'])->name('index');       // คอร์สทั้งหมด
            Route::get('/create', [CourseController::class, 'create'])->name('create'); // สร้างคอร์ส
            Route::post('/', [CourseController::class, 'store'])->name('store');      // บันทึกคอร์ส
            Route::get('/{id}', [CourseController::class, 'show'])->name('show');     // รายละเอียดคอร์ส
            Route::get('/person/{id}', [PersonController::class, 'show'])->name('person.show');      // บุคคล
            Route::delete('/{id}', [CourseController::class, 'destroy'])->name('destroy');      // ลบคอร์ส
            Route::get('/{id}/edit', [CourseController::class, 'edit'])->name('edit');      // แก้ไขคอร์ส
            Route::put('/{id}', [CourseController::class, 'update'])->name('update');      // อัพเดทคอร์ส
        });

        // Lesson routes
        Route::prefix('education/lesson')->group(function () {
            Route::put('/{id}', [LessonController::class, 'update'])->name('lesson.update');   // แก้ไขชื่อบทเรียน
            Route::delete('/{id}', [LessonController::class, 'destroyLesson'])->name('lesson.destroyLesson'); // ลบบทเรียน
        });

        // Media routes
        Route::prefix('education/medias')->name('medias.')->group(function () {
            Route::get('/create/{courseId?}', [MediaController::class, 'create'])->name('create');      // ฟอร์มสร้างสื่อ
            Route::post('/', [MediaController::class, 'store'])->name('store');       // บันทึกสื่อ
            Route::post('/lesson', [MediaController::class, 'storeLesson'])->name('lesson.store');      // สร้างบทเรียนใหม่
            Route::get('/{id}/edit', [MediaController::class, 'edit'])->name('edit');                    // หน้าแก้ไขสื่อ
            Route::put('/{id}', [MediaController::class, 'update'])->name('update');                     // อัพเดทสื่อ
            Route::delete('/{id}', [MediaController::class, 'destroy'])->name('destroy');                // ลบสื่อ
        });
});
    /** ---------------- Provider Routes ---------------- */
    Route::middleware('role:provider')->prefix('provider')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'provider'])->name('provider.dashboard');
        Route::get('/edit-profile', [CompaniesProfileController::class, 'edit'])->name('provider.profile.edit.self');
        Route::post('/edit-profile/store', [CompaniesProfileController::class, 'store'])->name('provider.profile.store.self');
    });

    /** ---------------- Education Routes ---------------- */
    Route::middleware('role:education')->prefix('education')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'education'])->name('education.dashboard');
        Route::get('/edit-education', [EducationProfileController::class, 'edit'])->name('profile-education.edit.self');
        Route::post('/edit-education/store', [EducationProfileController::class, 'store'])->name('profile-education.store.self');
    });

    /** ---------------- Jobber Routes ---------------- */
    Route::middleware('role:jobber')->prefix('jobber')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'jobber'])->name('jobber.dashboard');
        Route::get('/edit-profile', [ProfileDetailController::class, 'edit'])->name('profile-jobber.edit');
        Route::post('/edit-profile/store', [ProfileDetailController::class, 'store'])->name('profile-jobber.store');
        Route::post('/edit-profile/certificate', [CertificateController::class, 'store'])->name('certificates.store');
    });

    /** ---------------- User Profile (Breeze/Jetstream) ---------------- */
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';
