@extends('layouts.app')

@section('title', 'บุคคล')

@section('content')
<div class="w-full p-6 bg-base-200 rounded-2xl shadow">

    <!-- Header Section -->
    <div class="flex items-center justify-between border-b pb-3 mb-6">
        <!-- Left side -->
        <div class="flex items-baseline gap-3">
            <!-- ลิงก์รายละเอียดคอร์ส -->
            <a href="{{ route('courses.show', ['id' => ($course->c_id)]) }}" 
               class="text-xl text-base-content cursor-pointer hover:text-blue-600">
                รายละเอียด
            </a>

            <!-- ลิงก์บุคคล -->
            <a href="{{ route('courses.person.show', ['id' => $course->c_id]) }}"  
               class="text-3xl font-bold text-blue-600 underline cursor-pointer hover:text-blue-600">
                บุคคล
            </a>
        </div>

        <!-- Right side: Icon -->
        <div>
            <a href="{{ route('courses.edit', ['id' => ($course->c_id ?? $id)]) }}">
                <i class="fa-solid fa-gear text-xl text-base-content cursor-pointer hover:text-blue-600"></i>
            </a>
        </div>
    </div>

    <!-- Section: ผู้สอน -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">
            <i class="fa-solid fa-chalkboard-teacher mr-2 text-blue-600"></i>
            ผู้สอน
        </h2>
        <div class="flex items-center gap-4 p-4 bg-white rounded-xl shadow">
            <img src="https://i.pravatar.cc/100?img=5" class="w-16 h-16 rounded-full border shadow">
            <div>
                <h3 class="text-lg font-bold">ดร. สมชาย ใจดี</h3>
                <p class="text-gray-500">อาจารย์ประจำมหาวิทยาลัย</p>
            </div>
        </div>
    </div>

    <!-- Section: ผู้เข้าร่วม -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">
            <i class="fa-solid fa-users mr-2 text-blue-600"></i>
            ผู้เข้าร่วม
        </h2>
        <div class="grid md:grid-cols-2 gap-4">
            <!-- Card ผู้เข้าร่วม -->
            @foreach([['name'=>'กิตติ','role'=>'นักศึกษา','img'=>1],['name'=>'ส้มโอ','role'=>'พนักงานบริษัท','img'=>2],['name'=>'วิชัย','role'=>'ฟรีแลนซ์','img'=>3],['name'=>'น้ำฝน','role'=>'ครู','img'=>4]] as $p)
            <div class="flex items-center justify-between p-4 bg-white rounded-xl shadow">
                <div class="flex items-center gap-4">
                    <img src="https://i.pravatar.cc/100?img={{ $p['img'] }}" 
                         class="w-14 h-14 rounded-full border shadow">
                    <div>
                        <h3 class="text-lg font-bold">{{ $p['name'] }}</h3>
                        <p class="text-gray-500">{{ $p['role'] }}</p>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button class="px-3 py-1 bg-green-100 text-blue-600 rounded-lg hover:bg-blue-200">
                        <i class="fa-solid fa-certificate mr-1"></i> ออกใบเซอร์
                    </button>
                    <button class="px-3 py-1 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
                        <i class="fa-solid fa-user-xmark mr-1"></i> ไล่ออก
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
