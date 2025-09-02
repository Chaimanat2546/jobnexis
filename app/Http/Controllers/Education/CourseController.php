<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Course;
use App\Models\User;
use App\Models\Skill;
use App\Models\Media;
use App\Models\Exam;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourseController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        // ดึงเฉพาะคอร์สที่ user มีสิทธิ์เข้าถึง
        $coursesFromDB = Course::where(function($query) {
            $user = auth()->user();
            
            if ($user->hasRole('admin')) {
                // Admin เห็นทั้งหมด
                $query->whereRaw('1=1');
            } else {
                // User ทั่วไปเห็นเฉพาะคอร์สของตัวเอง
                $query->where('c_create_by_id', $user->id);
            }
        })->get();
        
        // แปลงข้อมูลจาก DB ให้ตรงตามที่ View ต้องการ
        $allCourses = $coursesFromDB->map(function ($course) {
            return [
                'id' => $course->c_id,
                'title'        => $course->c_name,
                'participants' => $course->participants ?? 0, // ใช้ accessor จาก model
                'status'       => $this->mapStatus($course->c_status),
                'image'        => $course->c_image,
            ];
        })->toArray();

        $perPage = 7;
        $page    = $request->get('page', 1);

        // Slice array ตามหน้า
        $coursesSlice = array_slice($allCourses, ($page - 1) * $perPage, $perPage);

        // สร้าง LengthAwarePaginator
        $pagedData = new LengthAwarePaginator(
            $coursesSlice,
            count($allCourses),
            $perPage,
            $page,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('education.courses.index', compact('pagedData'));
    }

    // Helper: แปลงสถานะ DB → ภาษาไทย
    private function mapStatus($dbStatus)
    {
        $statusMap = [
            'open'   => 'เผยแพร่',
            'draft'  => 'ยังไม่ส่งคำขออนุมัติ',
            'closed' => 'ไม่เผยแพร่',
            'pending' => 'รออนุมัติ',
        ];
        
        return $statusMap[$dbStatus] ?? 'ไม่ทราบสถานะ';
    }

    public function create()
    {
         $this->authorize('create', Course::class);
        $skills = Skill::orderBy('name', 'asc')->get(); // เรียง A-Z
        return view('education.courses.create', compact('skills'));
    }

    public function store(Request $request)
    {
        // แปลง skill จาก string → array
        $skillsArray = !empty($request->skills) ? explode(',', $request->skills) : [];
        $request->merge(['skills' => $skillsArray]);

        // Validate ฟิลด์
        $request->validate([
            'c_name'       => 'required|string|max:50',
            'c_description'=> 'nullable|string|max:200',
            'skills'       => 'required|array|min:1|max:5',
            'skills.*'     => 'string|exists:skills,name',
            'c_status'     => 'required|in:pending,draft',
            'c_image'      => 'nullable|image|max:2048',
        ]);

        // จัดการไฟล์ภาพ
        $imagePath = null;
        if ($request->hasFile('c_image')) {
            $imagePath = $request->file('c_image')->store('courses', 'public');
        }

        // สร้างรหัสคอร์สอัตโนมัติ
        $skillNames = $request->skills;
        $firstSkillName = $skillNames[0];
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        
        do {
            $random = '';
            for ($i = 0; $i < 6; $i++) {
                $random .= $chars[rand(0, strlen($chars) - 1)];
            }
            $c_code = strtoupper(substr($firstSkillName, 0, 3)) . '-' . $random;
        } while (Course::where('c_code', $c_code)->exists());

        // สร้าง Course
        $course = Course::create([
            'c_name' => $request->c_name,
            'c_description' => $request->c_description,
            'c_code' => $c_code,               
            'c_status' => $request->c_status,
            'c_image' => $imagePath,
            'c_create_by_id' => auth()->id(),
        ]);

        // เชื่อม Skills
        $skillIds = Skill::whereIn('name', $skillNames)->pluck('id')->toArray();
        $course->skills()->sync($skillIds);

        return redirect()->route('courses.index')->with('success', 'สร้างคอร์สสำเร็จ');
    }

    public function show($id)
    {
        // ดึงคอร์สตาม id
       $course = Course::with('skills')->where('c_id', $id)->firstOrFail();

       // ตรวจสอบสิทธิ์
        $this->authorize('view', $course);

        // ดึงบทเรียนพร้อมสื่อและไฟล์
        $lessons = \App\Models\Lesson::with(['medias.files', 'exams'])
            ->where('l_c_id', $id)
            ->orderBy('l_index')
            ->get();

        // ดึงสื่อที่ไม่มีบทเรียน
        $soloMedias = Media::with('files')
            ->whereNull('m_l_id')
            ->where('m_c_id', $id)
            ->get();

        // เพิ่มแบบทดสอบเดี่ยว
        $soloExams = Exam::whereNull('e_l_id')
            ->where('e_c_id', $id)
            ->orderBy('e_index')
            ->get();

        return view('education.courses.show', compact('course', 'lessons', 'soloMedias', 'soloExams'));
    }
    public function destroy($id)
    {
    $course = Course::findOrFail($id);

    $this->authorize('delete', $course);

    $course->deleteWithRelated();

    return redirect()->back()->with('success', 'ลบคอร์สเรียบร้อยแล้ว');
    }

    public function update(Request $request, $id)
    {
    $course = Course::findOrFail($id);

    $this->authorize('update', $course);

    $skillsArray = !empty($request->skills) ? explode(',', $request->skills) : [];
    $request->merge(['skills' => $skillsArray]);

    // validate
    $request->validate([
        'c_name'       => 'required|string|max:50',
        'c_description'=> 'nullable|string|max:200',
        'skills'       => 'required|array|min:1|max:5',
        'skills.*'     => 'string|exists:skills,name',
        'c_status'     => 'required|in:closed,draft,open,pending',
        'c_image'      => 'nullable|image|max:2048',
    ]);

    // อัปเดตข้อมูลทั่วไป
    $course->c_name = $request->c_name;
    $course->c_description = $request->c_description;
    $course->c_status = $request->c_status;

    // อัปโหลดรูปภาพใหม่ถ้ามี
    if ($request->hasFile('c_image')) {
        // ลบรูปเก่า
        if ($course->c_image && \Storage::disk('public')->exists($course->c_image)) {
            \Storage::disk('public')->delete($course->c_image);
        }
        
        $path = $request->file('c_image')->store('courses', 'public');
        $course->c_image = $path;
    }

    $course->save();

    // อัปเดต skills ใน pivot table course_skill
    if (!empty($skillsArray)) {
        $skillIds = \App\Models\Skill::whereIn('name', $skillsArray)->pluck('id')->toArray();
        $course->skills()->sync($skillIds);
    } else {
        $course->skills()->sync([]);
    }

    return redirect()->route('courses.show', ['id' => $course->c_id])
                     ->with('success', 'แก้ไขคอร์สเรียบร้อยแล้ว');

    }
    public function edit($id)
    {
    $course = Course::with('skills')->findOrFail($id); // โหลด skills ด้วย
    $this->authorize('update', $course); // ตรวจสอบสิทธิ์
    $skills = Skill::orderBy('name', 'asc')->get(); // ดึงทักษะทั้งหมดเรียง A-Z
    return view('education.courses.edit', compact('course', 'skills'));
    }
}
