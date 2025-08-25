<?php

namespace App\Http\Controllers;

use App\Models\User; // สมมติใช้ model User
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลจาก DB (เฉพาะ role = jobber)
        $pagedData = User::with('profile')
            ->where('role', 'jobber')
            ->paginate(7); // ยังคงใช้ paginate

        return view('admin.jobber', compact('pagedData'));
    }
}
