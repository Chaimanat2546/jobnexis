@extends('layouts.app')

@section('title', 'สร้างสื่อการสอน')

@section('content')
<div class="bg-base-200 p-6 rounded-lg shadow max-w-2xl mx-auto">

    <h2 class="text-2xl font-semibold mb-6 text-center">สร้างสื่อการสอน</h2>

    {{-- แสดงข้อความสำเร็จ --}}
    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 mb-6 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('medias.store') }}" method="POST" enctype="multipart/form-data"
          class="flex flex-col gap-6"
          x-data="mediaForm()"
          @submit.prevent="validateForm()">
        <input type="hidden" name="course_id" value="{{ $courseId }}">
        
        @csrf

    {{-- ครอบทั้งหมด --}}
    <div class="flex flex-col gap-1">

        {{-- Label บทเรียน --}}
        <label class="block font-medium">บทเรียน</label>

        {{-- แสดงรายการบทเรียน (สำหรับแก้ไข/ลบ realtime) --}}
        <div class="lessons-list mb-2">
            <div class="lesson-placeholder text-sm text-gray-400">ยังไม่ได้เลือกบทเรียน</div>
        </div>

        {{-- เลือกบทเรียน --}}
        <div class="flex flex-col gap-1">
            <select id="lesson_select" name="m_l_id">
                <option value="">-- เพิ่ม/เลือกบทเรียน --</option>
                @foreach($lessons as $lesson)
                    <option value="{{ $lesson->l_id }}">{{ $lesson->l_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

        {{-- ชื่อสื่อการสอน --}}
        <div class="flex flex-col gap-1 relative">
            <label class="block text-base-content mb-1">ชื่อสื่อการสอน</label>

            <div class="relative">
                <input type="text" name="m_name"
                    x-model="mediaName"
                    maxlength="50"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 pr-10 focus:outline-none focus:border-blue-600 focus:ring focus:ring-blue-100"
                    required>

                <!-- ตัวนับตัวอักษร ลอยมุมขวาล่าง -->
                <span class="absolute bottom-2 right-3 text-sm text-gray-500 pointer-events-none"
                    x-text="`${mediaName.length} / 50`"></span>
            </div>

            <!-- ข้อความแจ้งเตือน แยกออกมา -->
            <span class="text-red-600 text-sm mt-1" x-show="mediaNameError" x-cloak>
                กรุณากรอกชื่อสื่อการสอน
            </span>
        </div>

        {{-- คำอธิบายสื่อการสอน --}}
        <div class="flex flex-col gap-1 relative">
            <label class="block text-base-content mb-1">คำอธิบายสื่อการสอน</label>
            <textarea name="m_desc" x-model="mediaDesc" rows="4" maxlength="200"
                      class="w-full border border-gray-300 rounded-md px-3 py-2 pr-14 focus:outline-none focus:border-blue-600 focus:ring focus:ring-blue-100 resize-none"></textarea>
            <span class="absolute bottom-2 right-3 text-sm text-gray-500"
                  x-text="`${mediaDesc.length} / 200`"></span>
        </div>

        {{-- ไฟล์แนบ --}}
        <div class="flex flex-col gap-1" x-data="fileUpload()">
            <label class="block text-base-content mb-1">ไฟล์แนบ</label>

            <!-- กล่องอัปโหลด -->
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500"
                @click="$refs.fileInput.click()"
                @dragover.prevent
                @drop.prevent="handleDrop($event)">
                <p class="text-gray-600">ลากไฟล์มาวางที่นี่ หรือ <span class="text-blue-600 underline">เลือกไฟล์</span></p>
                <p class="text-xs text-gray-400 mt-1">รองรับหลายไฟล์ (PDF, DOCX, PNG, JPG)</p>
            </div>

            <!-- input file จริง แต่ซ่อน -->
            <input type="file" name="files[]" multiple class="hidden"
                x-ref="fileInput" @change="handleFiles($event)">

            <!-- แสดงรายการไฟล์ -->
            <div x-show="files.length > 0" class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                <template x-for="(file, index) in files" :key="index">
                    <div class="flex items-center justify-between p-2 border border-gray-300 rounded-lg bg-white shadow-sm">
                        <div class="flex items-center gap-2 flex-1 min-w-0">
                            <!-- ไอคอนตามนามสกุล -->
                            <i :class="getFileIcon(file.name) + ' text-lg flex-shrink-0'"></i>
                            <!-- ชื่อไฟล์ truncate -->
                            <span x-text="file.name" class="truncate"></span>
                        </div>
                        <button type="button" @click="removeFile(index)" 
                                class="ml-2 text-red-500 hover:text-red-700 font-bold flex-shrink-0">&times;</button>
                    </div>
                </template>
            </div>
        </div>

        {{-- ปุ่ม Action --}}
        <div class="col-span-1 md:col-span-2 flex justify-center gap-4 mt-10">
            <button type="submit" 
                    class="btn bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-3">
                สร้าง
            </button>
           <a href="{{ route('courses.show', ['id' => $courseId]) }}" 
            class="btn btn-outline text-base-content rounded-lg px-6 py-3">
                ยกเลิก
            </a>
        </div>
    </form>
</div>

<script>
let lessonPending = false;

function mediaForm() {
    return {
        mediaName: '',
        mediaDesc: '',
        mediaNameError: false,
        files: [],

        // ฟังก์ชันตรวจสอบไอคอนตามนามสกุล
        getFileIcon(filename) {
            const ext = filename.split('.').pop().toLowerCase();
            switch(ext) {
                case 'pdf': return 'fas fa-file-pdf text-red-500';
                case 'doc':
                case 'docx': return 'fas fa-file-word text-blue-500';
                case 'xls':
                case 'xlsx': return 'fas fa-file-excel text-green-600';
                case 'ppt':
                case 'pptx': return 'fas fa-file-powerpoint text-orange-500';
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                case 'svg': return 'fas fa-file-image text-purple-500';
                case 'mp4':
                case 'mov':
                case 'avi': return 'fas fa-file-video text-pink-500';
                default: return 'fas fa-file text-gray-500';
            }
        },

        validateForm() {
            if (lessonPending) {
                alert("กรุณารอสักครู่ กำลังสร้างบทเรียนใหม่...");
                return;
            }

            this.mediaNameError = this.mediaName.trim() === '';
            if (this.mediaNameError) return;

            // ตรวจสอบว่า m_l_id เป็น number
            const select = document.querySelector("#lesson_select");
            const value = select.value;
            if (value && isNaN(parseInt(value))) {
                alert("กรุณารอระบบสร้างบทเรียนใหม่ให้เสร็จ");
                return;
            }

            this.$el.submit();
        },

        handleFiles(event) {
            this.files = [...this.files, ...Array.from(event.target.files)];
            const dt = new DataTransfer();
            this.files.forEach(f => dt.items.add(f));
            this.$refs.fileInput.files = dt.files;
        },

        handleDrop(event) {
            const dropped = Array.from(event.dataTransfer.files);
            this.files = [...this.files, ...dropped];
            const dt = new DataTransfer();
            this.files.forEach(f => dt.items.add(f));
            this.$refs.fileInput.files = dt.files;
        },

        removeFile(index) {
            this.files.splice(index, 1);
            const dt = new DataTransfer();
            this.files.forEach(f => dt.items.add(f));
            this.$refs.fileInput.files = dt.files;
        }
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const lessonSelect = document.querySelector("#lesson_select");
    const lessonsList = document.querySelector(".lessons-list");
    const lessonIdsInput = document.querySelector("#lesson_ids");
    let lessonPending = false;
    let ts; // ประกาศ ts ที่ scope ที่สามารถเข้าถึงได้ทุกที่

    // ================= TomSelect =================
    ts = new TomSelect(lessonSelect, {
        placeholder: "--เพิ่ม/เลือกบทเรียน--",
        create: true,
        persist: false,
        sortField: { field: "text", direction: "asc" },
        plugins: ['remove_button'],
        onOptionAdd: function (value, data) {
            lessonPending = true;

            fetch("{{ route('medias.lesson.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ l_name: value, l_c_id: {{ $courseId }} })
            })
            .then(res => res.json())
            .then(data => {
                // ลบ option ชั่วคราวและเพิ่ม option ที่มี ID จริง
                ts.removeOption(value);
                ts.addOption({ value: data.l_id, text: data.l_name });
                ts.setValue(data.l_id, true);

                // อัพเดท UI
                const existing = lessonsList.querySelector(".lesson-item");
                if (existing) {
                    existing.setAttribute("data-id", data.l_id);
                    existing.querySelector(".lesson-name").textContent = data.l_name;
                    // อัพเดทปุ่ม edit และ delete ด้วย ID ใหม่
                    existing.querySelector(".edit-btn").setAttribute("data-value", data.l_id);
                    existing.querySelector(".delete-btn").setAttribute("data-value", data.l_id);
                } else {
                    addLessonToList(data.l_id, data.l_name);
                }

                lessonPending = false;
                updateLessonIds();
            })
            .catch(err => {
                console.error("Error creating lesson:", err);
                lessonPending = false;
                alert("เกิดข้อผิดพลาดในการสร้างบทเรียน");
            });
        }
    });

    // เมื่อเลือกบทเรียนจาก dropdown
    ts.on('change', function (value) {
        if (value && !lessonPending) {
            const option = ts.options[value];
            if (option) {
                const existing = lessonsList.querySelector(".lesson-item");
                if (existing) {
                    existing.setAttribute("data-id", value);
                    existing.querySelector(".lesson-name").textContent = option.text;
                    // อัพเดทปุ่ม edit และ delete
                    existing.querySelector(".edit-btn").setAttribute("data-value", value);
                    existing.querySelector(".delete-btn").setAttribute("data-value", value);
                } else {
                    addLessonToList(value, option.text);
                }
                updateLessonIds();
            }
        }
    });

    // ================= ฟังก์ชันช่วย =================
    function addLessonToList(id, name) {
        const placeholder = lessonsList.querySelector(".lesson-placeholder");
        if (placeholder) placeholder.remove();

        const div = document.createElement("div");
        div.className = "lesson-item flex items-center justify-between p-2 border rounded mb-1";
        div.setAttribute("data-id", id);
        div.innerHTML = `
            <div class="flex items-center gap-2">
                <span class="lesson-name">${name}</span>
                <button type="button" class="text-red-500 hover:text-red-700 font-bold remove-from-list">&times;</button>
            </div>
            <div class="flex gap-2">
                <i class="fa-solid fa-pen text-blue-600 cursor-pointer edit-btn" data-value="${id}"></i>
                <i class="fa-solid fa-trash text-red-600 cursor-pointer delete-btn" data-value="${id}"></i>
            </div>`;
        lessonsList.appendChild(div);
    }

    function updateLessonIds() {
        const item = lessonsList.querySelector(".lesson-item");
        if (lessonIdsInput) {
            lessonIdsInput.value = item ? item.getAttribute("data-id") : "";
        }
    }

    function updatePlaceholder() {
        const hasLesson = lessonsList.querySelector(".lesson-item");
        const placeholder = lessonsList.querySelector(".lesson-placeholder");
        if (!hasLesson && !placeholder) {
            const ph = document.createElement("div");
            ph.className = "lesson-placeholder text-sm text-gray-400";
            ph.textContent = "ยังไม่ได้เลือกบทเรียน";
            lessonsList.appendChild(ph);
        } else if (hasLesson && placeholder) {
            placeholder.remove();
        }
    }

    // ================= Event listener ปุ่ม =================
    lessonsList.addEventListener("click", function (e) {
        const removeBtn = e.target.closest(".remove-from-list");
        const editBtn = e.target.closest(".edit-btn");
        const deleteBtn = e.target.closest(".delete-btn");

        // ----- ลบออกจาก list (ไม่ลบจากฐานข้อมูล) -----
        if (removeBtn) {
            const lessonDiv = lessonsList.querySelector(".lesson-item");
            if (lessonDiv) {
                lessonDiv.remove();
                ts.clear(true);
                updateLessonIds();
                updatePlaceholder();
            }
        }

        // ----- แก้ไขชื่อ -----
        if (editBtn) {
            const value = editBtn.getAttribute("data-value");
            const lessonSpan = lessonsList.querySelector(`.lesson-item[data-id="${value}"] .lesson-name`);
            
            if (!lessonSpan) {
                console.error("ไม่พบ lesson span สำหรับ ID:", value);
                return;
            }

            const currentName = lessonSpan.textContent.trim();
            const newName = prompt("แก้ไขชื่อบทเรียน:", currentName);
            
            if (newName && newName.trim() !== "" && newName.trim() !== currentName) {
                // แสดง loading state
                lessonSpan.textContent = "กำลังอัพเดท...";
                
                // ใช้ named route
                const updateUrl = "{{ route('lesson.update', ':id') }}".replace(':id', value);
                console.log("Update URL:", updateUrl); // debug
                
                fetch(updateUrl, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": '{{ csrf_token() }}',
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ l_name: newName.trim() })
                })
                .then(res => {
                    console.log("Response status:", res.status);
                    console.log("Response headers:", res.headers.get('content-type'));
                    
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    console.log("Update response:", data);
                    if (data && data.success === true) {
                        // อัพเดท UI แบบ real-time
                        lessonSpan.textContent = data.lesson.l_name;
                        
                        // อัพเดท TomSelect option
                        if (typeof ts !== 'undefined' && ts.updateOption) {
                            ts.updateOption(value, { value: value, text: data.lesson.l_name });
                            
                            // ถ้า option นี้ถูกเลือกอยู่ ให้อัพเดท display text
                            if (ts.getValue() == value) {
                                ts.setValue(value, true);
                            }
                        }
                        
                        console.log("อัพเดทบทเรียนสำเร็จ");
                        alert("อัพเดทสำเร็จ!"); // เพิ่ม alert เพื่อทดสอบ
                    } else {
                        throw new Error("Response success is false");
                    }
                })
                .catch(err => {
                    console.error("Error updating lesson:", err);
                    lessonSpan.textContent = currentName; // คืนค่าเดิม
                    alert("เกิดข้อผิดพลาดในการอัพเดทบทเรียน: " + err.message);
                });
            }
        }

        // ----- ลบบทเรียน -----
        if (deleteBtn) {
            const value = deleteBtn.getAttribute("data-value");
            const lessonDiv = lessonsList.querySelector(`.lesson-item[data-id="${value}"]`);
            const lessonName = lessonDiv ? lessonDiv.querySelector(".lesson-name").textContent : "";
            
            if (!confirm(`คุณต้องการลบบทเรียน "${lessonName}" หรือไม่?`)) {
                return;
            }

            // แสดง loading state
            if (lessonDiv) {
                lessonDiv.style.opacity = "0.5";
                lessonDiv.style.pointerEvents = "none";
            }

            // ใช้ named route
            const deleteUrl = "{{ route('lesson.destroyLesson', ':id') }}".replace(':id', value);
            console.log("Delete URL:", deleteUrl); // debug

            fetch(deleteUrl, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": '{{ csrf_token() }}',
                    "Accept": "application/json"
                }
            })
            .then(res => {
                console.log("Delete response status:", res.status);
                console.log("Delete response headers:", res.headers.get('content-type'));
                
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                console.log("Delete response:", data);
                if (data && data.success === true) {
                    // ลบจาก UI แบบ real-time
                    if (lessonDiv) {
                        lessonDiv.remove();
                    }
                    
                    // ลบจาก TomSelect
                    if (typeof ts !== 'undefined' && ts.removeOption) {
                        ts.removeOption(value);
                        ts.clear(true);
                    }
                    
                    updateLessonIds();
                    updatePlaceholder();
                    
                    console.log("ลบบทเรียนสำเร็จ");
                    alert("ลบสำเร็จ!"); // เพิ่ม alert เพื่อทดสอบ
                } else {
                    throw new Error("Delete failed - success is false");
                }
            })
            .catch(err => {
                console.error("Error deleting lesson:", err);
                // คืนค่า UI เดิม
                if (lessonDiv) {
                    lessonDiv.style.opacity = "1";
                    lessonDiv.style.pointerEvents = "auto";
                }
                alert("เกิดข้อผิดพลาดในการลบบทเรียน: " + err.message);
            });
        }
    });

    // เรียกตอนโหลดหน้าเพื่อเช็ค placeholder
    updatePlaceholder();
});
</script>

@endsection
