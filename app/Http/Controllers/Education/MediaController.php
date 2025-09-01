<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Media;
use App\Models\MediaFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MediaController extends Controller
{
    use AuthorizesRequests;

    // แสดงฟอร์มสร้างสื่อการสอน
    public function create($courseId = null)
    {
        if ($courseId) {
        $course = Course::findOrFail($courseId);
        $this->authorize('manageContent', $course);
    }
    
    $lessons = Lesson::where('l_c_id', $courseId)->get();
    return view('education.medias.create', compact('lessons', 'courseId'));
    }

    // บันทึกสื่อการสอน พร้อมรองรับหลายไฟล์
    public function store(Request $request)
    {
        if ($request->course_id) {
            $course = Course::findOrFail($request->course_id);
            $this->authorize('manageContent', $course);
        }

        $request->validate([
            'm_name' => 'required|string|max:255',
            'm_l_id' => 'nullable|exists:lessons,l_id',
            'm_index' => 'nullable|integer',
            'files.*' => 'nullable|file|max:10240', // แต่ละไฟล์ไม่เกิน 10MB
        ]);

        // สร้าง Media
        $media = Media::create([
            'm_name' => $request->m_name,
            'm_l_id' => $request->m_l_id,
            'm_c_id' => $request->course_id,
            'm_index' => $request->m_index ?? 0,
            'm_path' => null, // ไฟล์หลายไฟล์อยู่ใน media_files
            'm_desc' => $request->m_desc,
        ]);

        // ตรวจสอบและบันทึกไฟล์หลายไฟล์อย่างปลอดภัย
        $uploadedFiles = $request->file('files') ?? []; // ถ้า null ให้เป็น array ว่าง

        foreach ($uploadedFiles as $file) {
            $path = $file->store('media', 'public');

            MediaFile::create([
                'mf_m_id' => $media->m_id,
                'mf_path' => $path,
                'mf_original_name' => $file->getClientOriginalName(),
                'mf_type' => $file->getClientMimeType(),
                'mf_size' => (int) ($file->getSize() / 1024), // KB
            ]);
        }
        $courseId = $request->course_id ?? ($media->lesson->l_c_id ?? null);

        if (!$courseId) {
            return redirect()->route('courses.index')->with('error', 'ไม่พบรหัสคอร์ส');
        }

        return redirect()->route('courses.show', ['id' => $courseId])
                 ->with('success', 'บันทึกสื่อการสอนเรียบร้อยแล้ว');
    }

    // สร้างบทเรียนใหม่ (สำหรับ modal)
    public function storeLesson(Request $request)
    {
        if ($request->l_c_id) {
            $course = Course::findOrFail($request->l_c_id);
            $this->authorize('manageContent', $course);
        }

        $request->validate([
            'l_name' => 'required|string|max:255',
            'l_c_id' => 'nullable|exists:courses,c_id',
            'l_description' => 'nullable|string',
            'l_status' => 'nullable|in:open,closed,draft',
            'l_index' => 'nullable|string',
        ]);

        $lesson = Lesson::create([
            'l_name' => $request->l_name,
            'l_description' => $request->l_description ?? null,
            'l_status' => $request->l_status ?? 'draft',
            'l_index' => $request->l_index ?? 0,
            'l_c_id' => $request->l_c_id ?? null,
        ]);

        return response()->json([
            'l_id' => $lesson->l_id,
            'l_name' => $lesson->l_name,
    ]);
    }

    // หน้าแก้ไขสื่อ
    public function edit($id)
    {
        $media = Media::with('files')->findOrFail($id);

        // ใช้ course_id จาก media หรือจากบทเรียน
        $courseId = $media->m_c_id ?? ($media->lesson->l_c_id ?? null);

        if (!$courseId) {
            $course = Course::findOrFail($courseId);
            $this->authorize('manageContent', $course);
            // fallback ถ้าไม่มี courseId
            return redirect()->route('courses.index')
                            ->with('error', 'ไม่พบรหัสคอร์ส');
        }

        $lessons = Lesson::where('l_c_id', $courseId)->get();

        return view('education.medias.edit', compact('media', 'lessons', 'courseId'));
    }

    // อัปเดตสื่อ
    public function update(Request $request, $id)
    {
        $media = Media::findOrFail($id);

        $courseId = $media->m_c_id ?? ($media->lesson->l_c_id ?? null);

        if ($courseId) {
            $course = Course::findOrFail($courseId);
            $this->authorize('manageContent', $course);
        }

        $media->m_name = $request->m_name;
        $media->m_desc = $request->m_desc;
        $media->m_l_id = $request->m_l_id ?: null;
        $media->save();

        // ลบไฟล์ที่เลือก
        if ($request->delete_files) {
            foreach ($request->delete_files as $fileId) {
                $file = $media->files()->find($fileId);
                if ($file && $file->mf_path) {
                    \Storage::disk('public')->delete($file->mf_path); // ลบไฟล์จาก storage
                    $file->delete();
                }
            }
        }

        // อัปโหลดไฟล์ใหม่
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $path = $uploadedFile->store('media', 'public'); // ใช้โฟลเดอร์เดียวกับ store()
                $media->files()->create([
                    'mf_m_id' => $media->m_id,
                    'mf_original_name' => $uploadedFile->getClientOriginalName(),
                    'mf_path' => $path,
                    'mf_type' => $uploadedFile->getClientMimeType(),
                    'mf_size' => (int) ($uploadedFile->getSize() / 1024),
                ]);
            }
        }

        // หา courseId สำหรับ redirect
        $courseId = $media->m_c_id ?? ($media->lesson->l_c_id ?? null);


        return redirect()->route('courses.show', ['id' => $courseId])
                 ->with('success', 'อัปเดตสื่อเรียบร้อยแล้ว');
    }
    // ลบสื่อ
    public function destroy($id)
    {
        $media = Media::with('files')->findOrFail($id);

        $courseId = $media->m_c_id ?? ($media->lesson->l_c_id ?? null);
        if ($courseId) {
            $course = Course::findOrFail($courseId);
            $this->authorize('manageContent', $course);
        }

        // ลบไฟล์จริงจาก storage
        foreach ($media->files as $file) {
            if ($file->mf_path) {
                Storage::disk('public')->delete($file->mf_path);
            }
        }

        // ลบข้อมูลไฟล์
        $media->files()->delete();

        // ลบ Media
        $media->delete();

        // redirect กลับไปยัง course
        $courseId = $media->m_c_id ?? ($media->lesson->l_c_id ?? null);

        return redirect()->route('courses.show', ['id' => $courseId])
                        ->with('success', 'ลบสื่อเรียบร้อยแล้ว');
    }
}
