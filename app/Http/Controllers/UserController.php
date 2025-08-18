<?php

namespace App\Http\Controllers;

use App\Models\User; // สมมติใช้ model User
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    // public function index()
    // {
    //     // ดึงข้อมูล 9 รายการต่อหน้า
    //     $users = User::paginate(9);
    //     return view('users.index', compact('users'));
    // }
    public function index()
    {
        // สมมติข้อมูลจาก DB
        $data = collect([
            ['id' => 1, 'name' => 'สมชาย ใจดี', 'email' => 'somchai@example.com', 'status' => 'Active'],
            ['id' => 2, 'name' => 'สมหญิง รักเรียน', 'email' => 'somying@example.com', 'status' => 'Inactive'],
            ['id' => 3, 'name' => 'กิติพงษ์ สายใจ', 'email' => 'kitipong@example.com', 'status' => 'Active'],
            ['id' => 4, 'name' => 'สุดารัตน์ สุขใจ', 'email' => 'sudarat@example.com', 'status' => 'Active'],
            ['id' => 5, 'name' => 'วีรพล กล้าหาญ', 'email' => 'weeraphon@example.com', 'status' => 'Inactive'],
            ['id' => 6, 'name' => 'จารุวรรณ จงรัก', 'email' => 'jaruwan@example.com', 'status' => 'Active'],
            ['id' => 7, 'name' => 'ธีระชัย ธรรมดี', 'email' => 'teerachai@example.com', 'status' => 'Inactive'],
            ['id' => 8, 'name' => 'สุนีย์ ศรีสุข', 'email' => 'sunee@example.com', 'status' => 'Active'],
            ['id' => 9, 'name' => 'ประวิทย์ พิพัฒน์', 'email' => 'prawit@example.com', 'status' => 'Active'],
            ['id' => 10, 'name' => 'สุชาติ สายสมร', 'email' => 'suchart@example.com', 'status' => 'Inactive'],
            ['id' => 11, 'name' => 'อรทัย อินทร', 'email' => 'ornthai@example.com', 'status' => 'Active'],
            ['id' => 12, 'name' => 'มานพ คงทน', 'email' => 'manop@example.com', 'status' => 'Inactive'],
            ['id' => 13, 'name' => 'ประทีป ใจงาม', 'email' => 'prateep@example.com', 'status' => 'Active'],
            ['id' => 14, 'name' => 'จิตรา กิจดี', 'email' => 'jittra@example.com', 'status' => 'Inactive'],
            ['id' => 15, 'name' => 'กมลชัย ชาญชัย', 'email' => 'kamonchai@example.com', 'status' => 'Active'],
            ['id' => 16, 'name' => 'พิมพ์พรรณ มุ่งดี', 'email' => 'pimphan@example.com', 'status' => 'Active'],
            ['id' => 17, 'name' => 'สิริพร สายทอง', 'email' => 'siriporn@example.com', 'status' => 'Inactive'],
            ['id' => 18, 'name' => 'อภิชาติ สุขใจ', 'email' => 'apichart@example.com', 'status' => 'Active'],
        ]);

        // แบ่งหน้า
        $perPage = 7;
        $currentPage = request()->get('page', 1);
        $pagedData = new LengthAwarePaginator(
            $data->forPage($currentPage, $perPage),
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => url()->current()]
        );

        return view('admin.jobber', compact('pagedData'));
    }
    public function indexProvider()
    {
        // สมมติข้อมูลจาก DB
        $data = collect([
            ['name' => 'บริษัท เอ บจก.', 'tax_id' => '0105551001234', 'email' => 'contact@a.com', 'jobs' => 12, 'status' => 'Active'],
            ['name' => 'บริษัท บี จำกัด', 'tax_id' => '0105551005678', 'email' => 'info@b.com', 'jobs' => 0, 'status' => 'Pending'],
            ['name' => 'บริษัท ซี บจก.', 'tax_id' => '0105551009012', 'email' => 'hr@c.com', 'jobs' => 8, 'status' => 'Banned'],
            ['name' => 'บริษัท ดี จำกัด', 'tax_id' => '0105551013456', 'email' => 'jobs@d.com', 'jobs' => 2, 'status' => 'Active'],
            ['name' => 'บริษัท อี จำกัด', 'tax_id' => '0105551017890', 'email' => 'apply@e.com', 'jobs' => 0, 'status' => 'Pending'],
            ['name' => 'บริษัท เอฟ จำกัด', 'tax_id' => '0105551021234', 'email' => 'career@f.com', 'jobs' => 10, 'status' => 'Active'],
            ['name' => 'บริษัท จี จำกัด', 'tax_id' => '0105551025678', 'email' => 'hr@g.com', 'jobs' => 3, 'status' => 'Banned'],
            ['name' => 'บริษัท เอช จำกัด', 'tax_id' => '0105551029012', 'email' => 'jobs@h.com', 'jobs' => 1, 'status' => 'Active'],
            ['name' => 'บริษัท ไอ จำกัด', 'tax_id' => '0105551033456', 'email' => 'contact@i.com', 'jobs' => 0, 'status' => 'Pending'],
            ['name' => 'บริษัท เจ จำกัด', 'tax_id' => '0105551037890', 'email' => 'info@j.com', 'jobs' => 7, 'status' => 'Active'],
        ]);

        // Pagination (หน้าละ 7)
        $perPage = 7;
        $currentPage = request()->get('page', 1);
        $pagedData = new LengthAwarePaginator(
            $data->forPage($currentPage, $perPage),
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => url()->current()]
        );

        return view('admin.provider', compact('pagedData'));
    }
    public function indexEducation()
    {
        // สมมติข้อมูลจาก DB
        $schools = collect([
            ['name' => 'โรงเรียนบ้านดอน', 'email' => 'ban-don@example.com', 'code' => 'SCH001', 'courses' => 5, 'status' => 'Active'],
            ['name' => 'โรงเรียนสวนหลวง', 'email' => 'suanluang@example.com', 'code' => 'SCH002', 'courses' => 0, 'status' => 'Pending'],
            ['name' => 'โรงเรียนอนุบาลเมืองใหม่', 'email' => 'anuban@example.com', 'code' => 'SCH003', 'courses' => 8, 'status' => 'Banned'],
            ['name' => 'โรงเรียนศรีสุข', 'email' => 'srisuk@example.com', 'code' => 'SCH004', 'courses' => 4, 'status' => 'Active'],
            ['name' => 'โรงเรียนวัดเหนือ', 'email' => 'watnue@example.com', 'code' => 'SCH005', 'courses' => 3, 'status' => 'Active'],
            ['name' => 'โรงเรียนหนองบัว', 'email' => 'nongbua@example.com', 'code' => 'SCH006', 'courses' => 0, 'status' => 'Pending'],
            ['name' => 'โรงเรียนบ้านหนองไผ่', 'email' => 'nongphai@example.com', 'code' => 'SCH007', 'courses' => 1, 'status' => 'Active'],
            ['name' => 'โรงเรียนบ้านป่า', 'email' => 'banpa@example.com', 'code' => 'SCH008', 'courses' => 7, 'status' => 'Banned'],
            ['name' => 'โรงเรียนมัธยมพัฒนา', 'email' => 'mathayom@example.com', 'code' => 'SCH009', 'courses' => 4, 'status' => 'Active'],
            ['name' => 'โรงเรียนวิทยาการ', 'email' => 'witthaya@example.com', 'code' => 'SCH010', 'courses' => 0, 'status' => 'Pending'],
        ]);

        $perPage = 7;
        $currentPage = request()->get('page', 1);

        $pagedData = new LengthAwarePaginator(
            $schools->forPage($currentPage, $perPage),
            $schools->count(),
            $perPage,
            $currentPage,
            ['path' => url()->current()]
        );

        return view('admin.education', compact('pagedData'));
    }
}
