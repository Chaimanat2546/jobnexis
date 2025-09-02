@extends('layouts.app')

@section('title', 'รายละเอียดคอร์สอบรม')

@section('content')
<div class="w-full p-6 bg-base-200 rounded-2xl shadow">
    <!-- Header Section -->
    <div class="flex items-center justify-between border-b pb-3 mb-4">
        <!-- Left side -->
        <div class="flex items-baseline gap-3">
            <a href="{{ route('courses.show', ['id' => $course->c_id]) }}" 
               class="text-3xl font-bold text-blue-600 underline cursor-pointer hover:text-blue-600">
                รายละเอียด
            </a>
            <a href="{{ route('courses.person.show', ['id' => $course->c_id]) }}"  
               class="text-xl text-base-content cursor-pointer hover:text-blue-600">
                บุคคล
            </a>
        </div>

        <!-- Right side: Icon -->
        <div>
            <a href="{{ route('courses.edit', ['id' => $course->c_id]) }}">
                <i class="fa-solid fa-gear text-xl text-base-content cursor-pointer hover:text-blue-600"></i>
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="w-full rounded-[20px] shadow pt-20 pb-20 pl-40 pr-40 text-white"
         style="background: linear-gradient(to bottom, rgb(125 211 252) 0%, rgb(37 99 235) 100%);">
        <div class="bg-base-200 text-base-content rounded-xl p-6 shadow-md flex gap-6">
            <!-- ฝั่งซ้าย: รายละเอียดคอร์ส -->
            <div class="w-1/2 space-y-4">
                <!-- ชื่อคอร์ส -->
                <div class="text-4xl font-bold flex justify-between items-center">
                    <span>{{ $course->c_name ?? 'ยังไม่มีข้อมูล' }}</span>
                </div>

                <!-- คำอธิบาย -->
                <div class="flex justify-between items-center">
                    <span>{{ $course->c_description ?? '"เพิ่มคำอธิบายคอร์สอบรมของคุณ"' }}</span>
                </div>

                <!-- Skills -->
                <div class="flex flex-wrap gap-2">
                    @forelse($course->skills->sortBy('name') as $skill)
                        <span class="px-3 py-1 rounded-full text-base-content border border-gray-400 {{ $loop->index % 2 == 0 ? 'bg-blue-200' : 'bg-base-200' }}">
                            {{ $skill->name }}
                        </span>
                    @empty
                        <span class="px-3 py-1 rounded-full bg-base-200 text-base-content border border-gray-400">
                            ยังไม่มีข้อมูล
                        </span>
                    @endforelse
                </div>

                <!-- รหัสคอร์ส -->
                <div class="flex items-center gap-2">
                    <h3>รหัสคอร์สอบรม:</h3>
                    <span>{{ $course->c_code ?? 'ยังไม่มีข้อมูล' }}</span>
                </div>

                <!-- สถานะคอร์ส -->
                <div class="flex items-center gap-2">
                    <h3 class="font-semibold">สถานะคอร์สอบรม:</h3>
                    @if ($course->status_text === 'เผยแพร่')
                        <span class="px-3 py-1 rounded-full bg-green-200 text-green-600 text-sm">{{ $course->status_text }}</span>
                    @elseif ($course->status_text === 'รออนุมัติ')
                        <span class="px-3 py-1 rounded-full bg-yellow-200 text-yellow-600 text-sm">{{ $course->status_text }}</span>
                    @elseif ($course->status_text === 'ยังไม่ส่งคำขออนุมัติ')
                        <span class="px-3 py-1 rounded-full bg-gray-300 text-gray-600 text-sm">{{ $course->status_text }}</span>
                    @elseif ($course->status_text === 'ไม่เผยแพร่')
                        <span class="px-3 py-1 rounded-full bg-red-200 text-red-600 text-sm">{{ $course->status_text }}</span>
                    @endif
                </div>
            </div>

            <!-- ฝั่งขวา: รูปภาพ -->
            <div class="w-1/2 rounded-4xl flex justify-center items-center">
                <img 
                    src="{{ $course->c_image ? asset('storage/'.$course->c_image) : asset('image/web-image/ai-robot.jpg') }}" 
                    alt="Image" 
                    class="w-full h-80 rounded-[20px] object-cover">
            </div>
        </div>
    </div>
</div>

<!-- กล่อง Action + รายการสื่อการสอน -->
<div class="w-full p-6 bg-base-200 rounded-2xl shadow mt-6">
    <!-- ปุ่ม Action -->
    <div class="flex justify-end gap-4 mb-6">
        <a href="{{ route('medias.create', ['courseId' => $course->c_id]) }}" 
           class="flex items-center gap-2 px-4 py-2 rounded-full border-2 border-dashed border-blue-600 text-blue-600 hover:bg-blue-100 transition">
            <span class="bg-blue-600 text-white w-7 h-7 flex items-center justify-center p-1 rounded-full">
                <i class="fa-solid fa-file"></i>
            </span>
            <span>สร้างสื่อการสอน</span>
        </a>

        <a href="{{ route('exams.create', ['courseId' => $course->c_id]) }}" 
            class="flex items-center gap-2 px-4 py-2 rounded-full border-2 border-dashed border-blue-600 text-blue-600 hover:bg-blue-100 transition">
                <span class="bg-blue-600 text-white w-7 h-7 flex items-center justify-center p-1 rounded-full">
                    <i class="fa-solid fa-clipboard-question"></i>
                </span>
                <span>สร้างแบบทดสอบ</span>
            </a>
    </div>

    <!-- กล่องย่อย: แสดงรายการสื่อการสอนและแบบทดสอบ -->
    <div class="max-w-4xl mx-auto space-y-4">

        <!-- แสดงบทเรียน -->
        @foreach($lessons as $lesson)
            <div x-data="{ open: false, menuOpen: false }" class="bg-white p-4 rounded-lg shadow border-b-2 border-gray-300">
                <div class="flex justify-between items-center">
                    <!-- ชื่อบทเรียน -->   
                    <span class="text-2xl font-semibold">{{ $lesson->l_name }}</span>

                    <!-- ปุ่มด้านขวา (Chevron + เมนู) -->
                    <div class="flex items-center gap-2">
                        <!-- ปุ่มเปิด/ปิด รายการสื่อ -->
                        <button @click="open = !open" class="p-2 hover:text-blue-600 rounded-full">
                            <i :class="open ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down'" class="transition-transform"></i>
                        </button>

                        <!-- จุด 3 จุด ของบทเรียน -->
                        <div class="relative">
                            <button @click="menuOpen = !menuOpen" class="p-2 hover:text-blue-600 rounded-full">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div x-show="menuOpen" @click.outside="menuOpen = false"
                                 class="absolute right-0 mt-2 w-40 bg-white border rounded-lg border-gray-300 shadow-lg z-50">

                                <!-- เปลี่ยนชื่อ -->
                                <form action="{{ route('lesson.update', $lesson->l_id) }}" method="POST" class="px-3 py-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="l_name" value="{{ $lesson->l_name }}"
                                           class="w-full border rounded border-gray-300 px-2 py-1 text-sm mb-2 focus:outline-none focus:border-blue-600 focus:ring focus:ring-blue-100">
                                    <button type="submit" class="w-full text-sm text-blue-600 hover:bg-blue-200 py-1 rounded">
                                        เปลี่ยนชื่อ
                                    </button>
                                </form>

                                <!-- ปุ่มลบ เปิด Modal -->
                                <label for="delete-lesson-modal-{{ $loop->index }}" 
                                    class="w-full text-sm text-red-600 hover:bg-red-200 py-1 rounded cursor-pointer block text-center">
                                    ลบ
                                </label>

                                {{-- Modal --}}
                                <input type="checkbox" id="delete-lesson-modal-{{ $loop->index }}" class="modal-toggle">
                                <div class="modal">
                                    <div class="modal-box text-center max-w-xs w-full rounded-2xl">
                                        <h3 class="font-bold text-lg">ยืนยันการลบบทเรียนนี้หรือไม่?</h3>
                                        <div class="modal-action justify-center gap-4">
                                            <!-- ใช้ form เดิมของคุณ -->
                                            <form action="{{ route('lesson.destroyLesson', $lesson->l_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-3">
                                                    ยืนยัน
                                                </button>
                                            </form>

                                            <label for="delete-lesson-modal-{{ $loop->index }}" 
                                                class="hover:bg-gray-200 text-base-content font-normal rounded-lg px-6 py-3">
                                                ยกเลิก
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- แสดงสื่อและแบบทดสอบภายใต้บทเรียน -->
                <div x-show="open" class="mt-3 space-y-2 pl-6">
                    <!-- สื่อการสอน -->
                    @if($lesson->medias && $lesson->medias->count() > 0)
                        <span class="font-semibold text-base-content">สื่อการสอน</span>
                        @foreach($lesson->medias as $media)
                            <div x-data="{ subOpen: false, menuOpen: false }" class="bg-gray-50 p-3 rounded relative">
                                <div class="flex justify-between items-center">
                                    <!-- ชื่อสื่ออยู่ฝั่งซ้าย -->
                                    <div class="flex items-center gap-2">
                                        <span class="bg-blue-600 text-white w-7 h-7 flex items-center justify-center p-1 rounded-full">
                                            <i class="fa-solid fa-file"></i>
                                        </span>
                                        <h4 class="text-base-content">{{ $media->m_name }}</h4>
                                    </div>

                                    <!-- Chevron + เมนูอยู่ฝั่งขวา -->
                                    <div class="flex items-center gap-2">
                                        <!-- Chevron -->
                                        <button @click="subOpen = !subOpen" class="p-2 hover:text-blue-600 rounded-full">
                                            <i :class="subOpen ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down'" class="transition-transform"></i>
                                        </button>

                                        <!-- เมนู -->
                                        <div class="relative">
                                            <button @click="menuOpen = !menuOpen" class="p-2 hover:text-blue-600 rounded-full">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div x-show="menuOpen" @click.outside="menuOpen = false"
                                                 class="absolute right-0 mt-2 w-32 bg-white border rounded-lg border-gray-300 shadow-lg z-50">

                                                <!-- แก้ไข -->
                                                <button type="button"
                                                        onclick="window.location='{{ route('medias.edit', $media->m_id) }}'"
                                                        class="w-full text-sm text-blue-600 hover:bg-blue-200 py-1 rounded">
                                                    แก้ไข
                                                </button>

                                                <!-- ปุ่มลบ เปิด Modal -->
                                                <label for="delete-media-modal-{{ $loop->parent->index }}-{{ $loop->index }}" 
                                                    class="w-full text-sm text-red-600 hover:bg-red-200 py-1 rounded cursor-pointer block text-center">
                                                    ลบ
                                                </label>

                                                {{-- Modal --}}
                                                <input type="checkbox" id="delete-media-modal-{{ $loop->parent->index }}-{{ $loop->index }}" class="modal-toggle">
                                                <div class="modal">
                                                    <div class="modal-box text-center max-w-xs w-full rounded-2xl">
                                                        <h3 class="font-bold text-lg">ยืนยันการลบสื่อการสอนนี้หรือไม่?</h3>
                                                        <div class="modal-action justify-center gap-4">
                                                            <!-- ใช้ form เดิมของคุณ -->
                                                            <form action="{{ route('medias.destroy', $media->m_id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-3">
                                                                    ยืนยัน
                                                                </button>
                                                            </form>

                                                            <label for="delete-media-modal-{{ $loop->parent->index }}-{{ $loop->index }}" 
                                                                class="hover:bg-gray-200 text-base-content font-normal rounded-lg px-6 py-3">
                                                                ยกเลิก
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- รายละเอียดสื่อ -->
                                <div x-show="subOpen" class="mt-2 space-y-2">
                                    <div class="p-3 bg-white rounded shadow-sm">
                                        @if(!empty($media->m_desc))
                                            <p class="text-base-content text-sm">{{ $media->m_desc }}</p>
                                        @else
                                            <p class="text-gray-400 italic text-sm">ยังไม่มีคำอธิบาย</p>
                                        @endif

                                        @if($media->files && $media->files->count() > 0)
                                            <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                @foreach($media->files as $file)
                                                    @php
                                                        $ext = strtolower(pathinfo($file->mf_original_name, PATHINFO_EXTENSION));
                                                        $icon = 'fa-file';
                                                        $color = 'text-gray-500';
                                                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
                                                        $isVideo = in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm', 'wmv', 'flv', '3gp', 'm4v']);

                                                        switch($ext) {
                                                            case 'pdf': $icon='fa-file-pdf'; $color='text-red-500'; break;
                                                            case 'doc':
                                                            case 'docx': $icon='fa-file-word'; $color='text-blue-500'; break;
                                                            case 'xls':
                                                            case 'xlsx': $icon='fa-file-excel'; $color='text-green-600'; break;
                                                            case 'ppt':
                                                            case 'pptx': $icon='fa-file-powerpoint'; $color='text-orange-500'; break;
                                                            case 'jpg':
                                                            case 'jpeg':
                                                            case 'png':
                                                            case 'gif':
                                                            case 'svg':
                                                            case 'webp': $icon='fa-file-image'; $color='text-purple-500'; break;
                                                            case 'mp4':
                                                            case 'mov':
                                                            case 'avi':
                                                            case 'mkv':
                                                            case 'webm':
                                                            case 'wmv':
                                                            case 'flv':
                                                            case '3gp':
                                                            case 'm4v': $icon='fa-file-video'; $color='text-pink-500'; break;
                                                        }

                                                        $fileUrl = asset('storage/'.$file->mf_path);
                                                    @endphp

                                                    <div class="bg-white border border-gray-300 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                                        <!-- Header ไฟล์ -->
                                                        <div class="flex items-center justify-between p-3 bg-gray-50 border-b border-gray-100">
                                                            <div class="flex items-center gap-2 flex-1 min-w-0 cursor-pointer" 
                                                                onclick="window.open('{{ $fileUrl }}', '_blank')">
                                                                <i class="fas {{ $icon }} {{ $color }} text-lg flex-shrink-0"></i>
                                                                <span class="truncate text-sm font-medium text-gray-700 hover:text-blue-600">{{ $file->mf_original_name }}</span>
                                                            </div>
                                                        </div>

                                                        <!-- Preview Area -->
                                                        <div class="p-3">
                                                            @if($isImage)
                                                                <div class="cursor-pointer group" onclick="openImageModal('{{ $fileUrl }}', '{{ $file->mf_original_name }}')">
                                                                    <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                                                                        <img src="{{ $fileUrl }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Preview">
                                                                    </div>
                                                                </div>
                                                            @elseif($isVideo)
                                                                <div class="cursor-pointer group">
                                                                    <div class="aspect-video bg-gray-900 rounded-lg overflow-hidden">
                                                                        <video class="w-full h-full object-cover" controls preload="metadata">
                                                                            <source src="{{ $fileUrl }}" type="video/{{ $ext }}">
                                                                            Your browser does not support the video tag.
                                                                        </video>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="py-4 text-center cursor-pointer group" onclick="window.open('{{ $fileUrl }}', '_blank')">
                                                                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-2 group-hover:bg-gray-200 transition-colors">
                                                                        <i class="fas {{ $icon }} {{ $color }} text-2xl"></i>
                                                                    </div>
                                                                    <p class="text-xs text-gray-500 group-hover:text-blue-600">คลิกเพื่อเปิดไฟล์</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- แบบทดสอบในบทเรียน -->
                    @if(isset($lesson->exams) && $lesson->exams->count() > 0)
                        <span class="font-semibold text-base-content mt-4 block">แบบทดสอบ</span>
                        @foreach($lesson->exams as $exam)
                            <div x-data="{ examOpen: false, examMenuOpen: false }" class="bg-yellow-50 p-3 rounded relative">
                                <div class="flex justify-between items-center">
                                    <!-- ชื่อแบบทดสอบอยู่ฝั่งซ้าย -->
                                    <div class="flex items-center gap-2">
                                        <span class="bg-blue-600 text-white w-7 h-7 flex items-center justify-center p-1 rounded-full">
                                            <i class="fa-solid fa-clipboard-question"></i>
                                        </span>
                                        <h4 class="text-base-content">{{ $exam->e_name }}</h4>
                                    </div>

                                    <!-- Chevron + เมนูอยู่ฝั่งขวา -->
                                    <div class="flex items-center gap-2">
                                        <!-- Chevron -->
                                        <button @click="examOpen = !examOpen" class="p-2 hover:text-blue-600 rounded-full">
                                            <i :class="examOpen ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down'" class="transition-transform"></i>
                                        </button>

                                        <!-- เมนู -->
                                        <div class="relative">
                                            <button @click="examMenuOpen = !examMenuOpen" class="p-2 hover:text-blue-600 rounded-full">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div x-show="examMenuOpen" @click.outside="examMenuOpen = false"
                                                 class="absolute right-0 mt-2 w-32 bg-white border rounded-lg border-gray-300 shadow-lg z-50">

                                                <!-- แก้ไข -->
                                                <button type="button"
                                                        onclick="window.location='{{ route('exams.edit', $exam->e_id) }}'"
                                                        class="w-full text-sm text-blue-600 hover:bg-blue-200 py-1 rounded">
                                                    แก้ไข
                                                </button>

                                                <!-- ปุ่มลบ เปิด Modal -->
                                                <label for="delete-lesson-exam-modal-{{ $loop->parent->index }}-{{ $loop->index }}" 
                                                    class="w-full text-sm text-red-600 hover:bg-red-200 py-1 rounded cursor-pointer block text-center">
                                                    ลบ
                                                </label>

                                                {{-- Modal --}}
                                                <input type="checkbox" id="delete-lesson-exam-modal-{{ $loop->parent->index }}-{{ $loop->index }}" class="modal-toggle">
                                                <div class="modal">
                                                    <div class="modal-box text-center max-w-xs w-full rounded-2xl">
                                                        <h3 class="font-bold text-lg">ยืนยันการลบแบบทดสอบนี้หรือไม่?</h3>
                                                        <div class="modal-action justify-center gap-4">
                                                            <form action="{{ route('exams.destroy', $exam->e_id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-3">
                                                                    ยืนยัน
                                                                </button>
                                                            </form>

                                                            <label for="delete-lesson-exam-modal-{{ $loop->parent->index }}-{{ $loop->index }}" 
                                                                class="hover:bg-gray-200 text-base-content font-normal rounded-lg px-6 py-3">
                                                                ยกเลิก
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- รายละเอียดแบบทดสอบ -->
                                <div x-show="examOpen" class="mt-2 space-y-2">
                                    <div class="p-3 bg-white rounded shadow-sm">
                                        @if(!empty($exam->e_description))
                                            <p class="text-base-content text-sm">{{ $exam->e_description }}</p>
                                        @else
                                            <p class="text-gray-400 italic text-sm">ยังไม่มีคำอธิบาย</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach

        <!-- แสดงสื่อเดี่ยว (ไม่มีบทเรียน) -->
        @if(isset($soloMedias) && $soloMedias->count() > 0)
            @foreach($soloMedias as $media)
                <div x-data="{ subOpen: false, menuOpen: false }" class="bg-white p-4 rounded-lg shadow relative border-b-2 border-gray-300">
                    <div class="flex justify-between items-center">
                        <!-- ชื่อสื่ออยู่ฝั่งซ้าย -->
                        <div class="flex items-center gap-2">
                            <span class="bg-blue-600 text-white w-7 h-7 flex items-center justify-center p-1 rounded-full">
                                <i class="fa-solid fa-file"></i>
                            </span>
                            <h4 class="text-base-content">{{ $media->m_name }}</h4>
                        </div>

                        <!-- Chevron + เมนูอยู่ฝั่งขวา -->
                        <div class="flex items-center gap-2">
                            <!-- Chevron -->
                            <button @click="subOpen = !subOpen" class="p-2 hover:text-blue-600 rounded-full">
                                <i :class="subOpen ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down'" class="transition-transform"></i>
                            </button>

                            <!-- เมนู -->
                            <div class="relative">
                                <button @click="menuOpen = !menuOpen" class="p-2 hover:text-blue-600 rounded-full">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <div x-show="menuOpen" @click.outside="menuOpen = false"
                                     class="absolute right-0 mt-2 w-32 bg-white border rounded border-gray-300 shadow z-50">

                                    <!-- แก้ไข -->
                                    <button type="button"
                                            onclick="window.location='{{ route('medias.edit', $media->m_id) }}'"
                                            class="w-full text-sm text-blue-600 hover:bg-blue-200 py-1 rounded">
                                        แก้ไข
                                    </button>

                                    <!-- ปุ่มลบ เปิด Modal -->
                                    <label for="delete-mediaOut-modal-{{ $loop->index }}" 
                                        class="w-full text-sm text-red-600 hover:bg-red-200 py-1 rounded cursor-pointer block text-center">
                                        ลบ
                                    </label>

                                    {{-- Modal --}}
                                    <input type="checkbox" id="delete-mediaOut-modal-{{ $loop->index }}" class="modal-toggle">
                                    <div class="modal">
                                        <div class="modal-box text-center max-w-xs w-full rounded-2xl">
                                            <h3 class="font-bold text-lg">ยืนยันการลบสื่อการสอนนี้หรือไม่?</h3>
                                            <div class="modal-action justify-center gap-4">
                                                <!-- ใช้ form เดิมของคุณ -->
                                                <form action="{{ route('medias.destroy', $media->m_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-3">
                                                        ยืนยัน
                                                    </button>
                                                </form>

                                                <label for="delete-mediaOut-modal-{{ $loop->index }}" 
                                                    class="hover:bg-gray-200 text-base-content font-normal rounded-lg px-6 py-3">
                                                    ยกเลิก
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- รายละเอียด -->
                    <div x-show="subOpen" class="mt-2 pl-6">
                        <div class="p-3 bg-gray-50 rounded shadow-sm">
                            @if(!empty($media->m_desc))
                                <p class="text-base-content text-sm">{{ $media->m_desc }}</p>
                            @else
                                <p class="text-gray-400 italic text-sm">ยังไม่มีคำอธิบาย</p>
                            @endif

                            @if($media->files && $media->files->count() > 0)
                                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($media->files as $file)
                                        @php
                                            $ext = strtolower(pathinfo($file->mf_original_name, PATHINFO_EXTENSION));
                                            $icon = 'fa-file';
                                            $color = 'text-gray-500';
                                            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
                                            $isVideo = in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm', 'wmv', 'flv', '3gp', 'm4v']);

                                            switch($ext) {
                                                case 'pdf': $icon='fa-file-pdf'; $color='text-red-500'; break;
                                                case 'doc':
                                                case 'docx': $icon='fa-file-word'; $color='text-blue-500'; break;
                                                case 'xls':
                                                case 'xlsx': $icon='fa-file-excel'; $color='text-green-600'; break;
                                                case 'ppt':
                                                case 'pptx': $icon='fa-file-powerpoint'; $color='text-orange-500'; break;
                                                case 'jpg':
                                                case 'jpeg':
                                                case 'png':
                                                case 'gif':
                                                case 'svg':
                                                case 'webp': $icon='fa-file-image'; $color='text-purple-500'; break;
                                                case 'mp4':
                                                case 'mov':
                                                case 'avi':
                                                case 'mkv':
                                                case 'webm':
                                                case 'wmv':
                                                case 'flv':
                                                case '3gp':
                                                case 'm4v': $icon='fa-file-video'; $color='text-pink-500'; break;
                                            }

                                            $fileUrl = asset('storage/'.$file->mf_path);
                                        @endphp

                                        <div class="bg-white border border-gray-300 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                            <!-- Header ไฟล์ -->
                                            <div class="flex items-center justify-between p-3 bg-gray-50 border-b border-gray-100">
                                                <div class="flex items-center gap-2 flex-1 min-w-0 cursor-pointer" 
                                                    onclick="window.open('{{ $fileUrl }}', '_blank')">
                                                    <i class="fas {{ $icon }} {{ $color }} text-lg flex-shrink-0"></i>
                                                    <span class="truncate text-sm font-medium text-gray-700 hover:text-blue-600">{{ $file->mf_original_name }}</span>
                                                </div>
                                            </div>

                                            <!-- Preview Area -->
                                            <div class="p-3">
                                                @if($isImage)
                                                    <div class="cursor-pointer group" onclick="openImageModal('{{ $fileUrl }}', '{{ $file->mf_original_name }}')">
                                                        <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                                                            <img src="{{ $fileUrl }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Preview">
                                                        </div>
                                                    </div>
                                                @elseif($isVideo)
                                                    <div class="cursor-pointer group">
                                                        <div class="aspect-video bg-gray-900 rounded-lg overflow-hidden">
                                                            <video class="w-full h-full object-cover" controls preload="metadata">
                                                                <source src="{{ $fileUrl }}" type="video/{{ $ext }}">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="py-4 text-center cursor-pointer group" onclick="window.open('{{ $fileUrl }}', '_blank')">
                                                        <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-2 group-hover:bg-gray-200 transition-colors">
                                                            <i class="fas {{ $icon }} {{ $color }} text-2xl"></i>
                                                        </div>
                                                        <p class="text-xs text-gray-500 group-hover:text-blue-600">คลิกเพื่อเปิดไฟล์</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <!-- แสดงแบบทดสอบเดี่ยว (ไม่มีบทเรียน) -->
        @if(isset($soloExams) && $soloExams->count() > 0)
            @foreach($soloExams as $exam)
                <div x-data="{ subOpen: false, menuOpen: false }" class="bg-white p-4 rounded-lg shadow relative border-b-2 border-gray-300">
                    <div class="flex justify-between items-center">
                        <!-- ชื่อแบบทดสอบอยู่ฝั่งซ้าย -->
                        <div class="flex items-center gap-2">
                            <span class="bg-blue-600 text-white w-7 h-7 flex items-center justify-center p-1 rounded-full">
                                <i class="fa-solid fa-clipboard-question"></i>
                            </span>
                            <h4 class="text-base-content">{{ $exam->e_name }}</h4>
                        </div>

                        <!-- Chevron + เมนูอยู่ฝั่งขวา -->
                        <div class="flex items-center gap-2">
                            <!-- Chevron -->
                            <button @click="subOpen = !subOpen" class="p-2 hover:text-blue-600 rounded-full">
                                <i :class="subOpen ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down'" class="transition-transform"></i>
                            </button>

                            <!-- เมนู -->
                            <div class="relative">
                                <button @click="menuOpen = !menuOpen" class="p-2 hover:text-blue-600 rounded-full">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <div x-show="menuOpen" @click.outside="menuOpen = false"
                                     class="absolute right-0 mt-2 w-32 bg-white border rounded border-gray-300 shadow z-50">

                                    <!-- แก้ไข -->
                                    <button type="button"
                                            onclick="window.location='{{ route('exams.edit', $exam->e_id) }}'"
                                            class="w-full text-sm text-blue-600 hover:bg-blue-200 py-1 rounded">
                                        แก้ไข
                                    </button>

                                    <!-- ปุ่มลบ เปิด Modal -->
                                    <label for="delete-exam-modal-{{ $loop->index }}" 
                                        class="w-full text-sm text-red-600 hover:bg-red-200 py-1 rounded cursor-pointer block text-center">
                                        ลบ
                                    </label>

                                    {{-- Modal --}}
                                    <input type="checkbox" id="delete-exam-modal-{{ $loop->index }}" class="modal-toggle">
                                    <div class="modal">
                                        <div class="modal-box text-center max-w-xs w-full rounded-2xl">
                                            <h3 class="font-bold text-lg">ยืนยันการลบแบบทดสอบนี้หรือไม่?</h3>
                                            <div class="modal-action justify-center gap-4">
                                                <form action="{{ route('exams.destroy', $exam->e_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-3">
                                                        ยืนยัน
                                                    </button>
                                                </form>

                                                <label for="delete-exam-modal-{{ $loop->index }}" 
                                                    class="hover:bg-gray-200 text-base-content font-normal rounded-lg px-6 py-3">
                                                    ยกเลิก
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- รายละเอียดแบบทดสอบ -->
                    <div x-show="subOpen" class="mt-2 pl-6">
                        <div class="p-3 bg-gray-50 rounded shadow-sm">
                            @if(!empty($exam->e_description))
                                <p class="text-base-content text-sm">{{ $exam->e_description }}</p>
                            @else
                                <p class="text-gray-400 italic text-sm">ยังไม่มีคำอธิบาย</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</div>

<script>    
// ฟังก์ชันสำหรับแสดง modal รูปภาพ
function openImageModal(src, title) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="max-w-4xl max-h-full p-4 relative">
            <img src="${src}" alt="${title}" class="max-w-full max-h-full object-contain rounded">
            <button onclick="this.closest('.fixed').remove()" 
                    class="absolute top-2 right-2 bg-white text-black rounded-full w-8 h-8 flex items-center justify-center hover:bg-gray-200 z-10">
                ×
            </button>
            <p class="text-white text-center mt-2 absolute bottom-2 left-1/2 transform -translate-x-1/2">${title}</p>
        </div>
    `;
    modal.onclick = (e) => { if(e.target === modal) modal.remove(); };
    document.body.appendChild(modal);
}
</script>

@endsection