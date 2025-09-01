<?php

namespace App\Http\Controllers;

use App\Models\Recruitment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecruitmentController extends Controller
{
    /** Admin: รายการงานของ provider คนที่ระบุ */
    public function adminIndex(Request $request, $userId)
    {
        // guard ง่าย ๆ
        if (Auth::user()->role !== 'admin') abort(403);

        // ดึงข้อมูลบริษัท (ถ้ามี) เพื่อโชว์หัวเรื่อง
        $provider = DB::table('users')->where('id', $userId)->first();
        $company  = DB::table('companies_profiles')->where('co_user_id', $userId)->first();

        [$q, $status, $type, $mode] = [
            $request->string('q')->toString(),
            $request->string('status')->toString(),
            $request->string('type')->toString(),
            $request->string('work_mode')->toString(),
        ];

        $recs = Recruitment::ownedBy($userId)
            ->when($q, function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('rc_title', 'ilike', "%{$q}%")
                      ->orWhere('rc_description', 'ilike', "%{$q}%")
                      ->orWhere('rc_requirements', 'ilike', "%{$q}%");
                });
            })
            ->when($status, fn($qq) => $qq->where('rc_status', $status))
            ->when($type, fn($qq) => $qq->where('rc_type', $type))
            ->when($mode, fn($qq) => $qq->where('rc_work_mode', $mode))
            ->orderByDesc('rc_posted_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.recruitments.index', [
            'isAdmin'  => true,
            'ownerId'  => (int) $userId,
            'provider' => $provider,
            'company'  => $company,
            'recs'     => $recs,
            'filters'  => compact('q','status','type','mode'),
        ]);
    }

    /** Provider: รายการงานของตัวเอง */
    public function providerIndex(Request $request)
    {
        if (Auth::user()->role !== 'provider') abort(403);

        $userId = Auth::id();
        $company = DB::table('companies_profiles')->where('co_user_id', $userId)->first();

        [$q, $status, $type, $mode] = [
            $request->string('q')->toString(),
            $request->string('status')->toString(),
            $request->string('type')->toString(),
            $request->string('work_mode')->toString(),
        ];

        $recs = Recruitment::ownedBy($userId)
            ->when($q, function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('rc_title', 'ilike', "%{$q}%")
                      ->orWhere('rc_description', 'ilike', "%{$q}%")
                      ->orWhere('rc_requirements', 'ilike', "%{$q}%");
                });
            })
            ->when($status, fn($qq) => $qq->where('rc_status', $status))
            ->when($type, fn($qq) => $qq->where('rc_type', $type))
            ->when($mode, fn($qq) => $qq->where('rc_work_mode', $mode))
            ->orderByDesc('rc_posted_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.recruitments.index', [ // reuse view เดิม
            'isAdmin'  => false,
            'ownerId'  => $userId,
            'provider' => Auth::user(),
            'company'  => $company,
            'recs'     => $recs,
            'filters'  => compact('q','status','type','mode'),
        ]);
    }

    /** ทั้ง Admin/Provider ใช้ร่วมกัน */
    public function edit($rcId)
    {
        $rec = Recruitment::findOrFail($rcId);

        $user = Auth::user();
        $isOwner = $rec->rc_u_id === $user->id;

        if (!($user->role === 'admin' || ($user->role === 'provider' && $isOwner))) {
            abort(403);
        }

        return view('admin.recruitments.edit', [
            'rec' => $rec,
            'isAdmin' => $user->role === 'admin',
        ]);
    }

    public function update(Request $request, $rcId)
    {
        $rec = Recruitment::findOrFail($rcId);

        $user = Auth::user();
        $isOwner = $rec->rc_u_id === $user->id;
        if (!($user->role === 'admin' || ($user->role === 'provider' && $isOwner))) {
            abort(403);
        }

        $data = $request->validate([
            'rc_title'           => ['required','string','max:255'],
            'rc_description'     => ['required','string'],
            'rc_requirements'    => ['nullable','string'],
            'rc_salary'          => ['nullable','string','max:255'],
            'rc_location_text'   => ['nullable','string','max:255'],
            'rc_location_link'   => ['nullable','url','max:2048'],
            'rc_type'            => ['required','in:full-time,part-time,intern,freelance'],
            'rc_work_mode'       => ['required','in:onsite,remote,hybrid'],
            'rc_status'          => ['required','in:open,closed,draft'],
            'rc_posted_at'       => ['nullable','date'],
            'rc_expire_at'       => ['nullable','date','after_or_equal:rc_posted_at'],
            'rc_application_url' => ['nullable','url','max:2048'],
        ]);

        // ถ้าไม่ส่ง posted_at มา ให้คงค่าของเดิม
        if (empty($data['rc_posted_at'])) {
            unset($data['rc_posted_at']);
        }

        $rec->fill($data)->save();

        // กลับไป list ให้ถูกฝั่ง
        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.providers.recruitments.index', $rec->rc_u_id)
                ->with('status', 'อัปเดตประกาศงานเรียบร้อย');
        }
        return redirect()
            ->route('provider.recruitments.index')
            ->with('status', 'อัปเดตประกาศงานเรียบร้อย');
    }
    public function createForAdmin($userId)
{
    if (Auth::user()->role !== 'admin') abort(403);

    // ดึงข้อมูลเบื้องต้นไว้โชว์หัวเรื่อง
    $provider = DB::table('users')->where('id', $userId)->first();
    $company  = DB::table('companies_profiles')->where('co_user_id', $userId)->first();

    return view('admin.recruitments.create', [
        'isAdmin'  => true,
        'ownerId'  => (int) $userId,
        'provider' => $provider,
        'company'  => $company,
    ]);
}

public function storeForAdmin(Request $request, $userId)
{
    if (auth::user()->role !== 'admin') abort(403);

    $data = $this->validatedRecruitment($request);
    $data['rc_u_id'] = (int) $userId;

    // ตั้งค่า posted_at เป็นตอนนี้ ถ้าไม่ส่งมา
    if (empty($data['rc_posted_at'])) {
        $data['rc_posted_at'] = now();
    }

    Recruitment::create($data);

    return redirect()
        ->route('admin.providers.recruitments.index', $userId)
        ->with('status', 'สร้างประกาศงานเรียบร้อย');
}

public function createForProvider()
{
    if (auth::user()->role !== 'provider') abort(403);

    $userId  = auth::id();
    $company = DB::table('companies_profiles')->where('co_user_id', $userId)->first();

    return view('admin.recruitments.create', [
        'isAdmin'  => false,
        'ownerId'  => $userId,
        'provider' => auth::user(),
        'company'  => $company,
    ]);
}

    public function storeForProvider(Request $request)
    {
        if (auth::user()->role !== 'provider') abort(403);

    $data = $this->validatedRecruitment($request);
    $data['rc_u_id'] = auth::id();

    if (empty($data['rc_posted_at'])) {
        $data['rc_posted_at'] = now();
    }

    Recruitment::create($data);

        return redirect()
            ->route('provider.recruitments.index')
            ->with('status', 'สร้างประกาศงานเรียบร้อย');
    }

/** ----- แชร์ rules ระหว่าง create/update ----- */
    private function validatedRecruitment(Request $request): array
    {
        return $request->validate([
        'rc_title'           => ['required','string','max:255'],
        'rc_description'     => ['required','string'],
        'rc_requirements'    => ['nullable','string'],
        'rc_salary'          => ['nullable','string','max:255'],

        'rc_location_text'   => ['nullable','string','max:255'],
        'rc_location_link'   => ['nullable','url','max:2048'],

        'rc_type'            => ['required','in:full-time,part-time,intern,freelance'],
        'rc_work_mode'       => ['required','in:onsite,remote,hybrid'],
        'rc_status'          => ['required','in:open,closed,draft'],

        // note: datetime-local => 'Y-m-d\TH:i'
        'rc_posted_at'       => ['nullable','date'],
        'rc_expire_at'       => ['nullable','date','after_or_equal:rc_posted_at'],

        'rc_application_url' => ['nullable','url','max:2048'],
    ]);
}

    /** ลบประกาศงาน (ทั้ง Admin/Provider ใช้ร่วมกัน) */
    public function destroy($rcId)
    {
        $rec = Recruitment::findOrFail($rcId);

        $user = Auth::user();
        $isOwner = $rec->rc_u_id === $user->id;

        if (!($user->role === 'admin' || ($user->role === 'provider' && $isOwner))) {
            abort(403);
        }

        $ownerId = $rec->rc_u_id;
        $rec->delete();

        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.providers.recruitments.index', $ownerId)
                ->with('status', 'ลบประกาศงานเรียบร้อย');
        }

        return redirect()
            ->route('provider.recruitments.index')
            ->with('status', 'ลบประกาศงานเรียบร้อย');
    }

}
