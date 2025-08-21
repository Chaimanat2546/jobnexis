<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Models\Education;
use App\Models\WorkExperience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class ProfileDetailController extends Controller
{
    use AuthorizesRequests;

    public function edit($userId = null)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $targetUserId = $userId; // admin ต้องส่งมาเสมอ
        } else {
            $targetUserId = $user->id; // jobber = ตัวเองเท่านั้น
        }

        $profile    = UserProfile::where('up_u_id', $targetUserId)->first();
        $educations = Education::where('ed_u_id', $targetUserId)->get() ?? collect();
        $works      = WorkExperience::where('we_u_id', $targetUserId)->get() ?? collect();

        return view('admin.edit-jobber', compact('profile', 'educations', 'works', 'targetUserId'));
    }

    public function store(Request $request, $userId = null)
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $targetUserId = $userId; // admin ต้องส่งมาเสมอ
        } else {
            $targetUserId = $user->id; // jobber = ตัวเองเท่านั้น
        }

        // ========== 1) เก็บข้อมูลโปรไฟล์ ==========
        UserProfile::updateOrCreate(
            ['up_u_id' => $targetUserId],
            [
                'up_prefix'     => $request->up_prefix,
                'up_name'       => $request->up_name,
                'up_phone'      => $request->up_phone,
                'up_birth_date' => $request->up_birth_date,
                'up_gender'     => $request->up_gender,
                'up_city'       => $request->up_city,
            ]
        );

        // ========== 2) เก็บการศึกษา ==========
        $keepEduIds = [];
        if ($request->has('educations')) {
            foreach ($request->educations as $edu) {
                $education = Education::updateOrCreate(
                    ['ed_id' => $edu['ed_id'] ?? null],
                    [
                        'ed_name'       => $edu['ed_name'],
                        'ed_start_date' => $edu['ed_start_date'],
                        'ed_end_date'   => $edu['ed_end_date'],
                        'ed_u_id'       => $targetUserId,
                    ]
                );
                $keepEduIds[] = $education->ed_id;
            }
        }
        Education::where('ed_u_id', $targetUserId)
            ->whereNotIn('ed_id', $keepEduIds)
            ->delete();

        // ========== 3) เก็บประสบการณ์ทำงาน ==========
        $keepWorkIds = [];
        if ($request->has('work_experiences')) {
            foreach ($request->work_experiences as $work) {
                $experience = WorkExperience::updateOrCreate(
                    ['we_id' => $work['we_id'] ?? null],
                    [
                        'we_company_name' => $work['we_company_name'],
                        'we_start_date'   => $work['we_start_date'],
                        'we_end_date'     => $work['we_end_date'] ?? null,
                        'we_u_id'         => $targetUserId,
                    ]
                );
                $keepWorkIds[] = $experience->we_id;
            }
        }
        WorkExperience::where('we_u_id', $targetUserId)
            ->whereNotIn('we_id', $keepWorkIds)
            ->delete();

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function destroyEducation($id)
    {
        try {
            $education = Education::findOrFail($id);
            $user = Auth::user();

            // เช็คสิทธิ์
            if ($user->role !== 'admin' && (int)$education->ed_u_id !== (int)$user->id) {
                return response()->json(['error' => 'ไม่สามารถลบข้อมูลนี้ได้'], 403);
            }

            $education->delete();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Delete education failed', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function destroyWork($id)
    {
        try {
            $work = WorkExperience::findOrFail($id);
            $user = Auth::user();

            if ($user->role !== 'admin' && (int)$work->we_u_id !== (int)$user->id) {
                return response()->json(['error' => 'ไม่สามารถลบข้อมูลนี้ได้'], 403);
            }

            $work->delete();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Delete work failed', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Server error'], 500);
        }
    }
}
