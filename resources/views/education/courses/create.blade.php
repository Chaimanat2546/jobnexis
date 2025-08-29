@extends('layouts.app')

@section('title', 'สร้างคอร์สอบรม')

@section('content')
<div class="bg-base-200 p-6 rounded-lg shadow max-w-5xl mx-auto">
    <h1 class="text-2xl text-base-content font-bold mb-6 text-center">สร้างคอร์สอบรม</h1>

    <form action="{{ route('courses.store') }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="grid grid-cols-1 md:grid-cols-2 gap-6"
          x-data="courseForm()"
          @submit.prevent="validateForm()">

        @csrf

        <!-- ซ้าย: อัปโหลดรูปภาพ -->
        <div class="flex flex-col gap-4 justify-center items-center w-full">
            <div class="border-2 border-dashed border-gray-400 rounded-lg bg-gray-200 overflow-hidden aspect-[16/10] w-full">
                <template x-if="!previewUrl">
                    <img src="{{ asset('image/web-image/ai-robot.jpg') }}" 
                         alt="Placeholder" 
                         class="w-full h-full object-cover">
                </template>
                <template x-if="previewUrl">
                    <img :src="previewUrl" 
                         class="w-full h-full object-cover">
                </template>
            </div>

            <label class="border-2 border-dashed border-blue-600 rounded-lg px-4 py-2 text-center cursor-pointer hover:border-blue-700">
                เลือกรูปภาพจากคอมพิวเตอร์ของคุณ
                <input type="file" 
                       class="hidden" 
                       name="c_image"
                       @change="previewUrl = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
            </label>
        </div>

        <!-- ขวา: ฟอร์มคอร์ส -->
        <div class="flex flex-col gap-5">

            <!-- ชื่อคอร์ส -->
            <div class="relative gap-1">
                <label class="block text-base-content mb-1">ชื่อคอร์สอบรม</label>
                <div class="relative">
                    <input type="text" 
                           name="c_name" 
                           x-model="courseName" 
                           maxlength="50"
                           @input="courseNameError = false"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 pr-14 focus:outline-none focus:border-blue-600 focus:ring focus:ring-blue-100">
                    
                    <span class="absolute top-1/2 right-3 -translate-y-1/2 text-sm text-gray-500" 
                          x-text="`${courseName.length} / 50`"></span>

                    <span class="absolute -bottom-5 left-0 text-red-600 text-sm" 
                          x-show="courseNameError">
                          กรุณากรอกชื่อคอร์ส
                    </span>
                </div>
            </div>

            <!-- คำอธิบาย -->
            <div class="relative gap-1">
                <label class="block text-base-content mb-1">คำอธิบายคอร์สอบรม</label>
                <div class="relative">
                    <textarea name="c_description" 
                              x-model="desc" 
                              rows="4" 
                              maxlength="200"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 pr-14 focus:outline-none focus:border-blue-600 focus:ring focus:ring-blue-100 resize-none"></textarea>
                    
                    <span class="absolute bottom-2 right-3 text-sm text-gray-500" 
                          x-text="`${desc.length} / 200`"></span>
                </div>
            </div>

            <!-- เลือกทักษะ -->
            <div class="relative gap-1">
                <label class="block text-base-content font-normal mb-1">ประเภททักษะ</label>

                <div class="flex flex-wrap gap-1 mb-2">
                    <template x-for="(skill,index) in selectedSkills" :key="index">
                        <span class="px-3 py-1 rounded-full text-base-content border border-gray-400"
                              :class="index % 2 === 0 ? 'bg-blue-200' : 'bg-base-200'">
                            <span x-text="skill"></span>
                            <button type="button" 
                                    @click="removeSkill(index)" 
                                    class="ml-1">✕</button>
                        </span>
                    </template>

                    <template x-if="selectedSkills.length === 0">
                        <span class="px-3 py-1 rounded-full bg-base-200 text-base-content border border-gray-400">
                            ยังไม่มีข้อมูล
                        </span>
                    </template>
                </div>

                <select x-model="currentSkill" 
                        @change="addSkill"
                        class="font-normal w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-600 focus:ring focus:ring-blue-100">
                    <option value="">เลือกทักษะ</option>
                    @foreach($skills as $skill)
                        <option value="{{ $skill->name }}">{{ $skill->name }}</option>
                    @endforeach
                </select>

                <input type="hidden" name="skills" :value="selectedSkills.join(',')">

                <span class="absolute -bottom-5 left-0 text-red-600 text-sm" 
                      x-show="skillError">
                      กรุณาเลือกอย่างน้อย 1 ทักษะ
                </span>
            </div>

            <!-- รหัสคอร์ส + Toggle เผยแพร่ -->
            <div class="flex items-start gap-6">

                <!-- รหัสคอร์ส -->
                <div class="flex flex-col w-1/2 gap-1">
                    <label class="block text-base-content mb-1">รหัสคอร์สอบรม</label>
                    <input type="text" 
                           name="c_code" 
                           x-model="courseCode"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-300 text-gray-600 cursor-not-allowed focus:outline-none"
                           readonly>
                </div>

                <!-- Toggle เผยแพร่คอร์สอบรม -->
                <div class="flex flex-col w-1/2 gap-1">
                    <label class="text-base-content mb-1">ขออนุมัติเผยแพร่คอร์สอบรม</label>
                    <div class="flex items-center h-full">
                        <div x-data="{ published: false }" 
                             @click="published = !published"
                             :class="published ? 'bg-blue-600' : 'bg-gray-300'"
                             class="w-14 h-7 rounded-full relative cursor-pointer transition-colors">
                            
                            <span class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full shadow-md transition-transform"
                                  :class="published ? 'translate-x-7' : 'translate-x-0'"></span>

                            <input type="hidden" 
                                   name="c_status" 
                                   :value="published ? 'pending' : 'draft'">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ปุ่ม Action -->
        <div class="col-span-1 md:col-span-2 flex justify-center gap-4 mt-10">
            <button type="submit" 
                    class="btn bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-3">
                สร้าง
            </button>
            <a href="{{ route('courses.index') }}" 
               class="btn btn-outline text-base-content rounded-lg px-6 py-3">
                ยกเลิก
            </a>
        </div>
    </form>
</div>

<script>
function courseForm() {
    return {
        previewUrl: null,
        courseName: '',
        desc: '',
        selectedSkills: [],
        currentSkill: '',
        courseCode: '',
        courseNameError: false,
        skillError: false,

        addSkill() {
            if (this.currentSkill && !this.selectedSkills.includes(this.currentSkill)) {
                this.selectedSkills.push(this.currentSkill);
                this.skillError = false;
                this.generateCode();
            }
            this.currentSkill = '';
        },

        removeSkill(index) {
            this.selectedSkills.splice(index, 1);
            if (this.selectedSkills.length === 0) {
                this.skillError = true;
            }
            this.generateCode();
        },

        generateCode() {
            if (this.selectedSkills.length > 0) {
                let skillAbbr = this.selectedSkills[0].substring(0, 3).toUpperCase();
                let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let code = '';

                do {
                    code = skillAbbr + '-';
                    for (let i = 0; i < 6; i++) {
                        code += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                } while (this.existingCodes && this.existingCodes.includes(code));

                this.courseCode = code;
            } else {
                this.courseCode = '';
            }
        },

        validateForm() {
            this.courseNameError = this.courseName.trim() === '';
            this.skillError = this.selectedSkills.length === 0;

            if (!this.courseNameError && !this.skillError) {
                this.$el.submit();
            }
        }
    }
}
</script>
@endsection
