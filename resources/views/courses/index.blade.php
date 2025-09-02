@extends('layouts.app')

@section('title', 'คอร์สทั้งหมด')

@section('content')
<div class="w-full p-6 bg-base-200 rounded-2xl shadow" x-data="{
    showEnroll:false,
    selectedCourseId:null,
    selectedCourseName:'',
    routeTpl: '{{ route('courses.enroll', ['id' => 'ID_PLACEHOLDER']) }}',
    openEnroll(id, name){ this.selectedCourseId=id; this.selectedCourseName=name; this.showEnroll=true; }
}">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-bold text-base-content">คอร์สทั้งหมด</h1>
            <div class="mt-2 join">
                <a href="{{ request()->fullUrlWithQuery(['tab' => 'all', 'page' => 1]) }}" class="join-item btn btn-sm {{ ($tab ?? 'all') === 'all' ? 'btn-primary' : '' }}">ทั้งหมด</a>
                <a href="{{ request()->fullUrlWithQuery(['tab' => 'my', 'page' => 1]) }}" class="join-item btn btn-sm {{ ($tab ?? 'all') === 'my' ? 'btn-primary' : '' }}">ที่สมัครแล้ว</a>
            </div>
        </div>
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="ค้นหาคอร์ส..."
                   class="input input-bordered">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <button class="btn btn-primary">ค้นหา</button>
        </form>
    </div>

    @if (session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700 border border-red-300">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700 border border-green-300">{{ session('success') }}</div>
    @endif

    @if($courses->count() === 0)
        <div class="p-6 text-center bg-white rounded-xl">ไม่พบคอร์ส</div>
    @else
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($courses as $course)
                <div class="p-4 bg-white rounded-xl shadow flex flex-col cursor-pointer transition transform hover:shadow-lg hover:-translate-y-0.5"
                     @click="
                        @if(auth()->check() && auth()->user()->role === 'jobber')
                            @if(in_array($course->c_id, $enrolledIds))
                                window.location='{{ route('courses.view', ['id' => $course->c_id]) }}'
                            @else
                                openEnroll({{ $course->c_id }}, '{{ addslashes($course->c_name) }}')
                            @endif
                        @else
                            window.location='{{ route('courses.view', ['id' => $course->c_id]) }}'
                        @endif
                     ">
                    <img src="{{ $course->c_image ? asset('storage/'.$course->c_image) : asset('image/web-image/ai-robot.jpg') }}"
                         alt="{{ $course->c_name }}" class="w-full h-40 object-cover rounded-lg mb-3">
                    <h3 class="text-lg font-bold mb-1 text-base-content">{{ $course->c_name }}</h3>
                    <p class="text-sm text-gray-600 line-clamp-2 mb-3">{{ $course->c_description }}</p>
                    <div class="mt-auto flex items-center justify-between gap-2">
                        @if(auth()->check() && auth()->user()->role === 'jobber')
                            @if(in_array($course->c_id, $enrolledIds))
                                <span class="badge badge-success">สมัครแล้ว</span>
                            @else
                                <span class="badge">เปิดรับสมัคร</span>
                            @endif
                        @else
                            <span class="badge">ดูรายละเอียด</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $courses->links() }}</div>

        <!-- Enroll Modal -->
        <template x-if="showEnroll">
            <div class="modal modal-open">
                <div class="modal-box">
                    <h3 class="text-lg font-bold mb-2">สมัครเข้าเรียน</h3>
                    <p class="mb-4">คอร์ส: <span class="font-semibold" x-text="selectedCourseName"></span></p>
                    <form x-ref="enrollForm" method="POST" @submit.prevent="$refs.enrollForm.action = routeTpl.replace('ID_PLACEHOLDER', selectedCourseId); $refs.enrollForm.submit();">
                        @csrf
                        <label class="form-control w-full mb-4">
                            <div class="label"><span class="label-text">กรอกรหัสคอร์ส</span></div>
                            <input type="text" name="code" class="input input-bordered w-full" required autocomplete="off"/>
                        </label>
                        <div class="modal-action">
                            <button type="button" class="btn" @click="showEnroll=false">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">ยืนยัน</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    @endif
</div>
@endsection
