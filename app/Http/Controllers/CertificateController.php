<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    // แสดงหน้าใบประกาศ
    public function index()
{
    $certificates = Certificate::where('cer_u_id', \Illuminate\Support\Facades\Auth::user()->id)->get();

    return view('admin.edit-jobber', compact('certificates'));
}


    // เพิ่มใบประกาศ
    public function store(Request $request)
    {
        $request->validate([
            'cer_name' => 'required|string|max:255',
            'cer_ref_number' => 'nullable|string|max:255',
            'cer_institute_name' => 'required|string|max:255',
            'cer_image_path' => 'required|string|max:255',
        ]);

        Certificate::create([
            'cer_name' => $request->cer_name,
            'cer_ref_number' => $request->cer_ref_number,
            'cer_institute_name' => $request->cer_institute_name,
            'cer_image_path' => $request->cer_image_path,
            'cer_u_id' => \Illuminate\Support\Facades\Auth::user()->id,
            'cer_from_lesson' => false, // ผู้ใช้ import
            'cer_publiced' => false,
        ]);

        return redirect()->route('certificates.index')->with('success', 'เพิ่มใบประกาศแล้ว');
    }

    // เปลี่ยนสถานะเผยแพร่/ซ่อน
    public function toggle($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->cer_publiced = !$certificate->cer_publiced;
        $certificate->save();

        return redirect()->route('certificates.index');
    }

    // ลบ (เฉพาะใบที่ import มา)
    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);
        if (!$certificate->cer_from_lesson) {
            $certificate->delete();
        }

        return redirect()->route('certificates.index');
    }
}
