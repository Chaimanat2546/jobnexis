<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // ทุกคนสามารถเข้าหน้า index ได้
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $user->id === $course->c_create_by_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // User ที่มี role education หรือ admin สามารถสร้างคอร์สได้
        return $user->role === 'education' || $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $user->id === $course->c_create_by_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $user->id === $course->c_create_by_id;
    }

    /**
     * Custom policy สำหรับจัดการเนื้อหา (lessons, media)
     */
    public function manageContent(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $user->id === $course->c_create_by_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Course $course): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Course $course): bool
    {
        return $user->role === 'admin';
    }
}