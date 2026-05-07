<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseMember;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CourseAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_course_content(): void
    {
        $course = $this->createCourse();

        $response = $this->get(route('courses.view', ['id' => $course->c_id]));

        $response
            ->assertRedirect(route('home'))
            ->assertSessionHas('showAuthModal', true)
            ->assertSessionHas('authForm', 'login');
    }

    public function test_jobber_must_enroll_before_viewing_course_content(): void
    {
        $course = $this->createCourse();
        $jobber = User::factory()->create(['role' => 'jobber']);

        $response = $this
            ->actingAs($jobber)
            ->get(route('courses.view', ['id' => $course->c_id]));

        $response
            ->assertRedirect(route('courses.catalog'))
            ->assertSessionHas('error');
    }

    public function test_enrolled_jobber_can_view_course_content(): void
    {
        $course = $this->createCourse();
        $jobber = User::factory()->create(['role' => 'jobber']);

        CourseMember::create([
            'cm_c_id' => $course->c_id,
            'cm_u_id' => $jobber->id,
            'cm_passed' => false,
        ]);

        $response = $this
            ->actingAs($jobber)
            ->get(route('courses.view', ['id' => $course->c_id]));

        $response
            ->assertOk()
            ->assertSee($course->c_name);
    }

    public function test_jobber_can_enroll_with_valid_code(): void
    {
        $course = $this->createCourse(['c_code' => 'ACCESS123']);
        $jobber = User::factory()->create(['role' => 'jobber']);

        $response = $this
            ->actingAs($jobber)
            ->post(route('courses.enroll', ['id' => $course->c_id]), [
                'code' => 'ACCESS123',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('courses.view', ['id' => $course->c_id]));

        $this->assertDatabaseHas('course_members', [
            'cm_c_id' => $course->c_id,
            'cm_u_id' => $jobber->id,
        ]);
    }

    public function test_jobber_cannot_enroll_with_wrong_code(): void
    {
        $course = $this->createCourse(['c_code' => 'ACCESS123']);
        $jobber = User::factory()->create(['role' => 'jobber']);

        $response = $this
            ->actingAs($jobber)
            ->from(route('courses.catalog'))
            ->post(route('courses.enroll', ['id' => $course->c_id]), [
                'code' => 'WRONG',
            ]);

        $response
            ->assertRedirect(route('courses.catalog'))
            ->assertSessionHas('error');

        $this->assertDatabaseMissing('course_members', [
            'cm_c_id' => $course->c_id,
            'cm_u_id' => $jobber->id,
        ]);
    }

    public function test_course_owner_can_manage_course(): void
    {
        $owner = User::factory()->create(['role' => 'education']);
        $course = $this->createCourse(['c_create_by_id' => $owner->id]);

        $response = $this
            ->actingAs($owner)
            ->get(route('courses.show', ['id' => $course->c_id]));

        $response
            ->assertOk()
            ->assertSee($course->c_name);
    }

    public function test_education_user_cannot_manage_another_education_course(): void
    {
        $owner = User::factory()->create(['role' => 'education']);
        $otherEducation = User::factory()->create(['role' => 'education']);
        $course = $this->createCourse(['c_create_by_id' => $owner->id]);

        $response = $this
            ->actingAs($otherEducation)
            ->get(route('courses.show', ['id' => $course->c_id]));

        $response->assertForbidden();
    }

    public function test_education_user_cannot_view_another_course_members(): void
    {
        $owner = User::factory()->create(['role' => 'education']);
        $otherEducation = User::factory()->create(['role' => 'education']);
        $course = $this->createCourse(['c_create_by_id' => $owner->id]);

        $response = $this
            ->actingAs($otherEducation)
            ->get(route('courses.person.show', ['id' => $course->c_id]));

        $response->assertForbidden();
    }

    public function test_education_user_cannot_update_lesson_in_another_course(): void
    {
        $owner = User::factory()->create(['role' => 'education']);
        $otherEducation = User::factory()->create(['role' => 'education']);
        $course = $this->createCourse(['c_create_by_id' => $owner->id]);
        $lesson = Lesson::create([
            'l_name' => 'Private Lesson',
            'l_description' => null,
            'l_status' => 'open',
            'l_index' => '1',
            'l_c_id' => $course->c_id,
        ]);

        $response = $this
            ->actingAs($otherEducation)
            ->put(route('lesson.update', ['id' => $lesson->l_id]), [
                'l_name' => 'Changed',
            ]);

        $response->assertForbidden();
    }

    public function test_catalog_search_does_not_match_enrollment_code(): void
    {
        $course = $this->createCourse([
            'c_name' => 'Frontend Fundamentals',
            'c_description' => 'Build user interfaces',
            'c_code' => 'SECRET123',
        ]);

        $response = $this->get(route('courses.catalog', ['q' => 'SECRET123']));

        $response
            ->assertOk()
            ->assertDontSee($course->c_name);
    }

    private function createCourse(array $overrides = []): Course
    {
        $ownerId = $overrides['c_create_by_id'] ?? User::factory()->create(['role' => 'education'])->id;

        return Course::create(array_merge([
            'c_name' => 'Course '.Str::random(8),
            'c_description' => 'Course content',
            'c_status' => 'open',
            'c_code' => 'CODE'.Str::upper(Str::random(8)),
            'c_create_by_id' => $ownerId,
            'c_create_at' => now()->toDateString(),
            'c_end_at' => now()->addMonth()->toDateString(),
        ], $overrides));
    }
}
