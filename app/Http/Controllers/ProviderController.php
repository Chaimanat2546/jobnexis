<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    public function index(Request $request)
    {
        $providers = User::query()
            ->from('users')
            ->where('users.role', 'provider')
            // join ข้อมูลบริษัท
            ->leftJoin('companies_profiles as cp', 'cp.co_user_id', '=', 'users.id')
            // เลือกคอลัมน์ที่ต้องใช้ (เติม/ลดตามต้องการ)
            ->select([
                'users.id',
                'users.email',
                'users.is_banned',
                'users.email_verified_at',
                'cp.co_name',
                'cp.co_number',
                'cp.co_email as company_email',
                'cp.co_phone',
                'cp.co_profile_img',
                'cp.co_banner_img as co_banner_img',
                'cp.co_type',
                'cp.co_jobber_amount',
                'cp.co_province',
            ])
            // นับจำนวนใบประกาศที่ "เผยแพร่" = เปิดรับงาน
            ->withCount([
                'recruitments as open_recruitments_count' => function ($q) {
                    $q->where('rc_status', 'open');
                },
            ])
            // เรียง: สถานะแบน -> ไอดี
            ->orderBy('users.is_banned') // false ก่อน true (PostgreSQL ok)
            ->orderBy('users.id')        // id น้อยไปมาก
            ->paginate(7)
            ->withQueryString();

        return view('admin.provider', compact('providers'));
    }
    public function toggleBan(User $user)
    {
        // ปรับสถานะแบน
        $user->is_banned = ! $user->is_banned;
        $user->save();

        return back()->with('success', $user->is_banned ? 'แบนผู้ใช้เรียบร้อย' : 'ปลดแบนผู้ใช้เรียบร้อย');
    }

    public function destroy(User $user)
    {
        // ถ้าตารางลูก (companies_profiles, recruitments, ฯลฯ) มี FK -> onDelete('cascade')
        // ลบผู้ใช้ได้ตรง ๆ; ถ้าไม่มีก็ควรลบตารางลูกก่อน
        DB::transaction(function () use ($user) {
            // ตัวอย่าง: ถ้าไม่มี cascade ก็ลบเองก่อน (ปล่อยคอมเมนต์ถ้ายังไม่ต้องใช้)
            // DB::table('companies_profiles')->where('co_user_id', $user->id)->delete();
            // DB::table('recruitments')->where('rc_u_id', $user->id)->delete();

            $user->delete();
        });

        return redirect()->route('admin.providers.index')->with('success', 'ลบผู้ใช้เรียบร้อย');
    }
}
