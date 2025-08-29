<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class PersonController extends Controller
{
    public function show($id)
    {
        // ถ้ามีฐานข้อมูล:
        $course = Course::where('c_id', $id)->first();

        // ถ้ายังไม่มีข้อมูลใน DB ให้สร้าง dummy ไว้ก่อน
        if (!$course) {
            $course = (object)[
                'c_id'       => (int) $id,
                'creator_id' => 1,
                'title'      => 'คอร์สจำลอง',
            ];
        }

        // ส่งทั้ง $course และ $id ไปให้ view
        return view('education.courses.person', compact('course', 'id'));
    }
}