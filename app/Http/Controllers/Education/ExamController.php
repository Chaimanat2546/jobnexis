<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExamController extends Controller
{
    use AuthorizesRequests;

    // แสดงฟอร์มสร้างแบบทดสอบ
    public function create($courseId = null)
    {
        if ($courseId) {
            $course = Course::findOrFail($courseId);
            $this->authorize('manageContent', $course);
        }
        
        $lessons = Lesson::where('l_c_id', $courseId)->get();
        return view('education.exams.create', compact('lessons', 'courseId'));
    }

    // บันทึกแบบทดสอบ
    public function store(Request $request)
    {
        // ตรวจสอบสิทธิ์
        if ($request->course_id) {
            $course = Course::findOrFail($request->course_id);
            $this->authorize('manageContent', $course);
        }

        $request->validate([
            'e_name' => 'required|string|max:50',
            'e_l_id' => 'nullable|exists:lessons,l_id',
            'e_description' => 'nullable|string|max:200',
        ]);

        $exam = Exam::create([
            'e_name' => $request->e_name,
            'e_description' => $request->e_description,
            'e_l_id' => $request->e_l_id,
            'e_c_id' => $request->course_id,
            'e_index' => 0,
        ]);

        return redirect()->route('courses.show', ['id' => $request->course_id])
                 ->with('success', 'บันทึกแบบทดสอบเรียบร้อยแล้ว');
    }

    // สร้างบทเรียนใหม่ (สำหรับ AJAX)
    public function storeLesson(Request $request)
    {
        // ตรวจสอบสิทธิ์
        if ($request->l_c_id) {
            $course = Course::findOrFail($request->l_c_id);
            $this->authorize('manageContent', $course);
        }

        $request->validate([
            'l_name' => 'required|string|max:50',
            'l_c_id' => 'nullable|exists:courses,c_id',
        ]);

        $lesson = Lesson::create([
            'l_name' => $request->l_name,
            'l_description' => null,
            'l_status' => 'draft',
            'l_index' => 0,
            'l_c_id' => $request->l_c_id,
        ]);

        return response()->json([
            'l_id' => $lesson->l_id,
            'l_name' => $lesson->l_name,
        ]);
    }

    // แก้ไขแบบทดสอบ
    public function edit($id)
    {
        $exam = Exam::findOrFail($id);

        $courseId = $exam->e_c_id;
        if ($courseId) {
            $course = Course::findOrFail($courseId);
            $this->authorize('manageContent', $course);
        }

        $lessons = Lesson::where('l_c_id', $courseId)->get();

        return view('education.exams.edit', compact('exam', 'lessons', 'courseId'));
    }

    // อัพเดทแบบทดสอบ
    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);
        
        // ตรวจสอบสิทธิ์
        $courseId = $exam->e_c_id;
        if ($courseId) {
            $course = Course::findOrFail($courseId);
            $this->authorize('manageContent', $course);
        }

        $request->validate([
            'e_name' => 'required|string|max:50',
            'e_l_id' => 'nullable|exists:lessons,l_id',
            'e_description' => 'nullable|string|max:200',
        ]);

        $exam->update([
            'e_name' => $request->e_name,
            'e_description' => $request->e_description,
            'e_l_id' => $request->e_l_id ?: null,
        ]);

        return redirect()->route('courses.show', ['id' => $courseId])
                 ->with('success', 'อัพเดทแบบทดสอบเรียบร้อยแล้ว');
    }

    // ดูรายละเอียดแบบทดสอบ
    public function show($id)
    {
        $exam = Exam::with(['course', 'lesson'])->findOrFail($id);

        // ตรวจสอบสิทธิ์
        $course = Course::findOrFail($exam->e_c_id);
        $this->authorize('view', $course);

        return view('education.exams.show', compact('exam'));
    }

    // ลบแบบทดสอบ
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);

        $courseId = $exam->e_c_id;
        if ($courseId) {
            $course = Course::findOrFail($courseId);
            $this->authorize('manageContent', $course);
        }

        $exam->delete();

        return redirect()->route('courses.show', ['id' => $courseId])
                        ->with('success', 'ลบแบบทดสอบเรียบร้อยแล้ว');
    }
}