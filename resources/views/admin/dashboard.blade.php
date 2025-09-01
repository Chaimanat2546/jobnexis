@extends('layouts.app')

@section('title', 'แดชบอร์ด')

@section('content')
    <div class="flex justify-between gap-24">
        <div class="w-full shadow stat bg-base-100 stats rounded-xl">
            <div class="text-2xl text-blue-600 stat-figure">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-title">ผู้ใช้งานทั้งหมด</div>
            <div class="stat-value">{{ number_format($totalUsers) }} คน</div>
            <div class="stat-desc">ผู้หางาน+ผู้ประกอบการ+สถานศึกษา</div>
        </div>
        <div class="w-full shadow stat bg-base-100 stats rounded-xl">
            <div class="text-2xl text-teal-600 stat-figure">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <div class="stat-title">คอร์สอบรมทั้งหมด</div>
            <div class="stat-value">{{ number_format($totalCourses) }} คอร์ส</div>
            <div class="stat-desc">จำนวนคอร์สที่มีในระบบ</div>
        </div>
        <div class="w-full shadow stat bg-base-100 stats rounded-xl">
            <div class="text-2xl stat-figure text-sky-600">
                <i class="fa-solid fa-scroll"></i>
            </div>
            <div class="stat-title">งานที่เปิดรับ</div>
            <div class="stat-value">{{ number_format($openRecruitments) }} ตำแหน่ง</div>
            <div class="stat-desc">จำนวนตำแหน่งที่ยังเปิดรับสมัคร</div>
        </div>
    </div>
    <div class="mt-4">
        <x-user-stats-board
    :endpoint="route('admin.userStats.data')"
    :roles="['jobber','provider','education']"
    :labels="['jobber'=>'ผู้หางาน','provider'=>'ผู้ประกอบการ','education'=>'สถานศึกษา']"
    :palette="['jobber'=>'#2563eb','provider'=>'#14b8a6','education'=>'#8b5cf6']"
    title="สถิติผู้ใช้งาน"
/>
    </div>
@endsection
