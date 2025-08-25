<?php

namespace App\Http\Controllers;

use App\Models\CompaniesProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompaniesProfileController extends Controller
{
    public function edit(Request $request, $userId = null)
    {
        $auth = Auth::user();

        // กำหนด user เป้าหมาย: admin = userId ที่ส่งมา, provider = ตัวเอง
        $targetUserId = $userId ?? $auth->id;

        // guard: ถ้าไม่ใช่ admin แต่กำลังแก้ที่ไม่ใช่ของตัวเอง -> 403
        if ($auth->role !== 'admin' && $userId) {
        return redirect()->route('provider.profile.edit');
    }

        $profile = CompaniesProfile::firstOrNew(['co_user_id' => $targetUserId]);

        return view('admin.edit-provider', [
            'profile'        => $profile,
            'targetUserId'   => $targetUserId,
            'isAdminEditing' => $auth->role === 'admin' && $targetUserId !== $auth->id,
        ]);
    }

    public function store(Request $request, $userId = null)
    {
        $auth = Auth::user();

        // ดึงให้ครบ: route param > hidden field > auth id
        $effectiveUserId = (int) ($userId ?? $request->input('target_user_id') ?? $auth->id);

        // ความปลอดภัย:
        // - ถ้าไม่ใช่ admin ห้ามแก้ของคนอื่น
        // - provider ต้องแก้ได้เฉพาะของตัวเองเท่านั้น
        if ($auth->role !== 'admin' && $effectiveUserId !== (int) $auth->id) {
            abort(403, 'Forbidden');
        }

        $data = $request->validate([
            'co_name'           => ['required', 'string', 'max:255'],
            'co_email'          => ['nullable', 'email', 'max:255'],
            'co_phone'          => ['nullable', 'string', 'max:50'],
            'co_birthday'       => ['nullable', 'date'],
            'co_type'           => ['nullable', 'string', 'max:100'],
            'co_number'         => ['nullable', 'string', 'max:100'],
            'co_jobber_amount'  => ['nullable', 'integer', 'min:0'],
            'co_address'        => ['nullable', 'string', 'max:1000'],
            'co_province'       => ['nullable', 'string', 'max:255'],
            'co_details'        => ['nullable', 'string', 'max:5000'],
            'co_profile_img'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'co_banner_img'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
        ]);

        $profile = CompaniesProfile::firstOrNew(['co_user_id' => $effectiveUserId]);
        $profile->fill($data);
        $profile->co_user_id = $effectiveUserId;

        if ($request->hasFile('co_profile_img')) {
            $path = $request->file('co_profile_img')->store('companies/profile', 'public');
            $profile->co_profile_img = $path;
        }
        if ($request->hasFile('co_banner_img')) {
            $path = $request->file('co_banner_img')->store('companies/banner', 'public');
            // ถ้า DB ใช้ co_img ให้เซต $profile->co_banner_img = $path; (มี alias ใน Model ตามที่เราทำไว้)
            $profile->co_banner_img = $path;
        }

        $profile->save();

        $routeParams = $auth->role === 'admin' ? ['userId' => $effectiveUserId] : [];
    return redirect()
        ->route('provider.profile.edit', $routeParams) // provider => /edit-provider | admin => /edit-provider/{userId}
        ->with('success', 'บันทึกโปรไฟล์เรียบร้อยแล้ว');
    }
}
