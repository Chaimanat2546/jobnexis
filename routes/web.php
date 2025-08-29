<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Education\CourseController;
use App\Http\Controllers\Education\PersonController;
use App\Http\Controllers\Education\MediaController;
use App\Http\Controllers\Education\LessonController;

Route::get('/', function () {
    return view('welcome');
})->name('/');

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

    // Jober routes
    Route::middleware('role:jobber')->group(function () {
        Route::get('/jobber/dashboard', [DashboardController::class, 'jobber'])->name('jobber.dashboard');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
