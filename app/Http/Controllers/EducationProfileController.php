<?php

namespace App\Http\Controllers;

use App\Models\EducationProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationProfileController extends Controller
{
    public function edit(Request $request, $userId = null)
{
$auth = Auth::user();
$targetUserId = $userId ?? $auth->id;


// Basic authorization: admin can edit anyone, education can edit self only
if ($auth->role !== 'admin' && $targetUserId != $auth->id) {
abort(403);
}


$profile = EducationProfile::firstOrNew(['e_u_id' => $targetUserId]);


// Provinces from config (fallback to empty array)
$provinces = config('th_provinces', []);


return view('admin.edit-education', [
'profile' => $profile,
'targetUserId' => $targetUserId,
'isAdmin' => $auth->role === 'admin',
'provinces' => $provinces,
]);
}


public function store(Request $request, $userId = null)
{
$auth = Auth::user();
$targetUserId = $userId ?? $auth->id;


if ($auth->role !== 'admin' && $targetUserId != $auth->id) {
abort(403);
}


$data = $request->validate([
'e_name' => ['required','string','max:255'],
'e_phone' => ['nullable','string','max:30'],
'e_email' => ['required','email','max:255'],
'e_website' => ['nullable','url','max:255'],
'e_birthday' => ['nullable','date'],
'e_number' => ['nullable','string','max:100'],
'e_address' => ['nullable','string','max:500'],
'e_province' => ['nullable','string','max:100'],
'e_detail' => ['nullable','string','max:2000'],
]);


$profile = EducationProfile::firstOrNew(['e_u_id' => $targetUserId]);
$profile->fill($data);
$profile->e_u_id = $targetUserId;
$profile->save();


// Redirect back to the correct edit page
if ($auth->role === 'admin') {
return redirect()->route('admin.profile-education.edit', ['userId' => $targetUserId])
->with('success', 'บันทึกโปรไฟล์ (Education) สำเร็จ');
}


return redirect()->route('profile-education.edit')
->with('success', 'บันทึกโปรไฟล์ (Education) สำเร็จ');
}
}
