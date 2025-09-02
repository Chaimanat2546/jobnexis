<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Exam;
use App\Models\Course;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class QuestionController extends Controller
{
    use AuthorizesRequests;

    public function create($examId)
    {
        $exam = Exam::findOrFail($examId);
        
        // ตรวจสอบสิทธิ์ผ่าน course
        $course = Course::findOrFail($exam->e_c_id);
        $this->authorize('manageContent', $course);

        $skills = config('skills');
        $questionCount = $exam->questions()->count();

        return view('education.questions.create', compact('exam', 'skills', 'questionCount'));
    }

    public function store(Request $request, $examId)
    {
        $exam = Exam::findOrFail($examId);
        
        // ตรวจสอบสิทธิ์
        $course = Course::findOrFail($exam->e_c_id);
        $this->authorize('manageContent', $course);

        $request->validate([
            'q_text' => 'required|string',
            'q_skill_category' => 'nullable|string',
            'q_skill' => 'nullable|string',
            'q_points' => 'integer|min:1|max:10',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer|min:0'
        ]);

        // สร้างคำถาม
        $question = Question::create([
            'q_e_id' => $examId,
            'q_text' => $request->q_text,
            'q_skill_category' => $request->q_skill_category,
            'q_skill' => $request->q_skill,
            'q_order' => $exam->questions()->count() + 1,
            'q_type' => 'multiple_choice',
            'q_points' => $request->q_points ?? 1
        ]);

        // สร้างตัวเลือก
        foreach ($request->options as $index => $optionText) {
            QuestionOption::create([
                'qo_q_id' => $question->q_id,
                'qo_text' => $optionText,
                'qo_is_correct' => $index == $request->correct_option,
                'qo_order' => $index + 1
            ]);
        }

        return redirect()->route('questions.create', $examId)
                        ->with('success', 'เพิ่มคำถามเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $examId = $question->q_e_id;
        
        // ตรวจสอบสิทธิ์
        $exam = Exam::findOrFail($examId);
        $course = Course::findOrFail($exam->e_c_id);
        $this->authorize('manageContent', $course);

        $question->options()->delete();
        $question->delete();

        return redirect()->route('questions.create', $examId)
                        ->with('success', 'ลบคำถามเรียบร้อยแล้ว');
    }
}