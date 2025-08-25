@extends('layouts.app')

@section('title', 'จัดการโปรไฟล์')

@section('content')
    <div class="p-4 overflow-x-auto border shadow bg-base-200 rounded-2xl">
        <div class="flex items-center justify-between">
            <div class="w-full">
                <h1>โปรไฟล์</h1>
                <p>จัดการข้อมูลบัญชีและการตั้งค่าของคุณ</p>
            </div>
            <div class="flex flex-col justify-end w-full gap-4">
                <div class="flex gap-4">
                    <fieldset class="fieldset">
                        <legend class="mb-1 fieldset-legend">ชื่อ-นามสุกล</legend>
                        <input type="text" class="pl-2 border border-gray-300 input w-72" placeholder="ชื่อ-นามสุกล" />
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="mb-1 fieldset-legend">อีเมล</legend>
                        <label class="border border-gray-300 input validator w-72">
                            <input type="email" placeholder="example@site.com" required />
                        </label>
                    </fieldset>
                </div>
                <div class="flex gap-4">
                    <fieldset class="fieldset">
                        <legend class="mb-1 fieldset-legend">เบอร์โทรศัพท์</legend>
                        <label class="border border-gray-300 input validator w-72">
                            <input type="tel" class="tabular-nums" required placeholder="Phone" pattern="[0-9]*"
                                minlength="10" maxlength="10" title="Must be 10 digits" />
                        </label>
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="mb-1 fieldset-legend">วันเกิด</legend>
                        <input type="date" class="pl-2 border border-gray-300 input w-72" />
                    </fieldset>
                </div>
                <div class="flex gap-4">
                    <fieldset class="fieldset">
                        <legend class="mb-1 fieldset-legend">เพศ</legend>
                        <select class="pl-2 border border-gray-300 select w-72" required>
                            <option value="">-- เลือกเพศ --</option>
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                            <option value="อื่นๆ">อื่นๆ</option>
                        </select>
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="mb-1 fieldset-legend">จังหวัด</legend>
                        <select class="pl-2 border border-gray-300 select w-72" required>
                            <option value="">-- เลือกจังหวัด --</option>
                            <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
                            <option value="กระบี่">กระบี่</option>
                            <option value="กาญจนบุรี">กาญจนบุรี</option>
                            <option value="กาฬสินธุ์">กาฬสินธุ์</option>
                            <option value="กำแพงเพชร">กำแพงเพชร</option>
                            <option value="ขอนแก่น">ขอนแก่น</option>
                            <option value="จันทบุรี">จันทบุรี</option>
                            <option value="ฉะเชิงเทรา">ฉะเชิงเทรา</option>
                            <option value="ชลบุรี">ชลบุรี</option>
                            <option value="ชัยนาท">ชัยนาท</option>
                            <option value="ชัยภูมิ">ชัยภูมิ</option>
                            <option value="ชุมพร">ชุมพร</option>
                            <option value="เชียงราย">เชียงราย</option>
                            <option value="เชียงใหม่">เชียงใหม่</option>
                            <option value="ตรัง">ตรัง</option>
                            <option value="ตราด">ตราด</option>
                            <option value="ตาก">ตาก</option>
                            <option value="นครนายก">นครนายก</option>
                            <option value="นครปฐม">นครปฐม</option>
                            <option value="นครพนม">นครพนม</option>
                            <option value="นครราชสีมา">นครราชสีมา</option>
                            <option value="นครศรีธรรมราช">นครศรีธรรมราช</option>
                            <option value="นครสวรรค์">นครสวรรค์</option>
                            <option value="นราธิวาส">นราธิวาส</option>
                            <option value="น่าน">น่าน</option>
                            <option value="บึงกาฬ">บึงกาฬ</option>
                            <option value="บุรีรัมย์">บุรีรัมย์</option>
                            <option value="ปทุมธานี">ปทุมธานี</option>
                            <option value="ประจวบคีรีขันธ์">ประจวบคีรีขันธ์</option>
                            <option value="ปราจีนบุรี">ปราจีนบุรี</option>
                            <option value="ปัตตานี">ปัตตานี</option>
                            <option value="พระนครศรีอยุธยา">พระนครศรีอยุธยา</option>
                            <option value="พังงา">พังงา</option>
                            <option value="พัทลุง">พัทลุง</option>
                            <option value="พิจิตร">พิจิตร</option>
                            <option value="พิษณุโลก">พิษณุโลก</option>
                            <option value="เพชรบุรี">เพชรบุรี</option>
                            <option value="เพชรบูรณ์">เพชรบูรณ์</option>
                            <option value="แพร่">แพร่</option>
                            <option value="พะเยา">พะเยา</option>
                            <option value="ภูเก็ต">ภูเก็ต</option>
                            <option value="มหาสารคาม">มหาสารคาม</option>
                            <option value="มุกดาหาร">มุกดาหาร</option>
                            <option value="แม่ฮ่องสอน">แม่ฮ่องสอน</option>
                            <option value="ยโสธร">ยโสธร</option>
                            <option value="ยะลา">ยะลา</option>
                            <option value="ร้อยเอ็ด">ร้อยเอ็ด</option>
                            <option value="ระนอง">ระนอง</option>
                            <option value="ระยอง">ระยอง</option>
                            <option value="ราชบุรี">ราชบุรี</option>
                            <option value="ลพบุรี">ลพบุรี</option>
                            <option value="ลำปาง">ลำปาง</option>
                            <option value="ลำพูน">ลำพูน</option>
                            <option value="เลย">เลย</option>
                            <option value="ศรีสะเกษ">ศรีสะเกษ</option>
                            <option value="สกลนคร">สกลนคร</option>
                            <option value="สงขลา">สงขลา</option>
                            <option value="สตูล">สตูล</option>
                            <option value="สมุทรปราการ">สมุทรปราการ</option>
                            <option value="สมุทรสงคราม">สมุทรสงคราม</option>
                            <option value="สมุทรสาคร">สมุทรสาคร</option>
                            <option value="สระแก้ว">สระแก้ว</option>
                            <option value="สระบุรี">สระบุรี</option>
                            <option value="สิงห์บุรี">สิงห์บุรี</option>
                            <option value="สุโขทัย">สุโขทัย</option>
                            <option value="สุพรรณบุรี">สุพรรณบุรี</option>
                            <option value="สุราษฎร์ธานี">สุราษฎร์ธานี</option>
                            <option value="สุรินทร์">สุรินทร์</option>
                            <option value="หนองคาย">หนองคาย</option>
                            <option value="หนองบัวลำภู">หนองบัวลำภู</option>
                            <option value="อ่างทอง">อ่างทอง</option>
                            <option value="อุดรธานี">อุดรธานี</option>
                            <option value="อุตรดิตถ์">อุตรดิตถ์</option>
                            <option value="อุทัยธานี">อุทัยธานี</option>
                            <option value="อุบลราชธานี">อุบลราชธานี</option>
                            <option value="อำนาจเจริญ">อำนาจเจริญ</option>
                        </select>
                    </fieldset>
                </div>
            </div>
        </div>
        <hr class="my-12 border-gray-300">
        <div class="flex items-center justify-between">
            <div class="w-full">
                <h1>ประสบการณ์การศึกษา</h1>
                <p>ข้อมูลวุฒิการศึกษาของคุณ จะช่วยให้นายจ้างประเมิน<br>ความเหมาะสมกับตำแหน่งงานได้ง่ายขึ้น</p>
            </div>
            <div class="flex flex-col justify-end w-full gap-4" id="education-container">
                <!-- ตัวอย่างแถวแรก -->
                <div class="relative">
                    <div class="flex gap-4">
                        <fieldset class="fieldset">
                            <legend class="mb-1 fieldset-legend">สถานศึกษาและสาขาวิชา</legend>
                            <input type="text" class="pl-2 border border-gray-300 input w-72"
                                placeholder="ชื่อสถานศึกษาและสาขาวิชา" />
                        </fieldset>
                        <fieldset class="fieldset">
                            <legend class="mb-1 fieldset-legend">ปีการศึกษา</legend>
                            <input type="text" class="pl-2 border border-gray-300 input w-72"
                                placeholder="ปีการศึกษา" />
                        </fieldset>
                    </div>
                    <!-- ปุ่มลบ -->
                    <div class="flex justify-end w-full mt-1">
                        <button type="button" class="text-red-600 delete-row right-2">
                            <i class="fa-solid fa-trash"></i> ลบ
                        </button>
                    </div>
                </div>

                <button type="button" id="add-education"
                    class="w-full text-blue-600 border-2 border-blue-600 border-dashed rounded-lg btn btn-sm">
                    <i class="fa-solid fa-plus"></i>
                    <p>เพิ่มประสบการณ์การศึกษา</p>
                </button>
            </div>
        </div>
        <hr class="my-12 border-gray-300">
        <div class="flex items-center justify-between">
            <div class="w-full">
                <h1>ประสบการณ์ทำงาน</h1>
                <p>ประสบการณ์ทำงานของคุณ เป็นองค์ประกอบ<br>สำคัญที่ช่วยให้นายจ้างสามารถประเมินความเหมาะสม</p>
            </div>
            <div class="flex flex-col justify-end w-full gap-4" id="work-container">
                <!-- ตัวอย่างแถวแรก -->
                <div class="relative">
                    <div class="flex gap-4">
                        <fieldset class="fieldset">
                            <legend class="mb-1 fieldset-legend">ชื่อบริษัท</legend>
                            <input type="text" class="pl-2 border border-gray-300 input w-72"
                                placeholder="ชื่อบริษัท" />
                        </fieldset>
                        <fieldset class="fieldset">
                            <legend class="mb-1 fieldset-legend">ช่วงเวลาทำงาน</legend>
                            <input type="text" class="pl-2 border border-gray-300 input w-72"
                                placeholder="เช่น 2019 - 2022" />
                        </fieldset>
                    </div>
                    <!-- ปุ่มลบ -->
                    <div class="flex justify-end w-full mt-1">
                        <button type="button" class="text-red-600 delete-row right-2">
                            <i class="fa-solid fa-trash"></i> ลบ
                        </button>
                    </div>

                </div>

                <button type="button" id="add-work"
                    class="w-full text-blue-600 border-2 border-blue-600 border-dashed rounded-lg btn btn-sm">
                    <i class="fa-solid fa-plus"></i>
                    <p>เพิ่มประสบการณ์ทำงาน</p>
                </button>
                <div class="flex justify-end w-full mt-4">
                    <button class="p-2 text-white bg-blue-600 btn hover:bg-blue-700">
                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                        บันทึกข้อมูล
                    </button>
                </div>

            </div>

        </div>
        <hr class="my-12 border-gray-300">
        <div class="flex flex-col items-start gap-4">
            <div class="flex justify-between w-full">
                <h1>ประกาศนียบัตร</h1>
                <button onclick="document.getElementById('addForm').classList.toggle('hidden')"
                    class="p-2 text-blue-600 border-2 border-blue-600 border-dashed rounded-lg btn btn-sm">
                    <i class="fa-solid fa-plus"></i> เพิ่มประกาศนียบัตร
                </button>
            </div>

            <!-- ฟอร์มเพิ่ม -->
            <div id="addForm" class="hidden w-full p-4 border rounded-lg bg-base-200">
                <form method="POST" action="{{ route('certificates.store') }}">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <input name="cer_name" type="text" placeholder="ชื่อคอร์ส" class="w-full pl-2 border input"
                            required />
                        <input name="cer_ref_number" type="text" placeholder="รหัสใบประกาศ"
                            class="w-full pl-2 border input" />
                        <input name="cer_institute_name" type="text" placeholder="ชื่อสถาบัน"
                            class="w-full pl-2 border input" required />
                        <input name="cer_image_path" type="text" placeholder="ลิงก์รูปภาพ"
                            class="w-full pl-2 border input" required />
                    </div>
                    <button type="submit" class="px-4 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        บันทึก
                    </button>
                </form>
            </div>

            <!-- รายการใบประกาศ -->
            <x-cert-tabs :certificates="$certificates" />
        </div>
    </div>


    <script>
        function createRow(type) {
            const row = document.createElement('div');
            row.classList.add('relative');

            if (type === 'education') {
                row.innerHTML = `
                <div class="flex gap-4">
                    <fieldset class="fieldset">
                        <legend class="mb-1 fieldset-legend">สถานศึกษาและสาขาวิชา</legend>
                        <input type="text" class="pl-2 border border-gray-300 input w-72"
                            placeholder="ชื่อสถานศึกษาและสาขาวิชา" />
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="mb-1 fieldset-legend">ปีการศึกษา</legend>
                        <input type="text" class="pl-2 border border-gray-300 input w-72" placeholder="ปีการศึกษา" />
                    </fieldset>
                </div>
                <div class="flex justify-end w-full mt-1">
                    <button type="button" class="text-red-600 delete-row right-2">
                        <i class="fa-solid fa-trash"></i> ลบ
                    </button>
                </div>
            `;
            } else if (type === 'work') {
                row.innerHTML = `
                <div class="flex gap-4">
                    <fieldset class="fieldset">
                        <legend class="mb-1 fieldset-legend">ชื่อบริษัท</legend>
                        <input type="text" class="pl-2 border border-gray-300 input w-72"
                            placeholder="ชื่อบริษัท" />
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="mb-1 fieldset-legend">ช่วงเวลาทำงาน</legend>
                        <input type="text" class="pl-2 border border-gray-300 input w-72" placeholder="เช่น 2019 - 2022" />
                    </fieldset>
                </div>
                <div class="flex justify-end w-full mt-1">
                    <button type="button" class="text-red-600 delete-row right-2">
                        <i class="fa-solid fa-trash"></i> ลบ
                    </button>
                </div>
            `;
            }

            // ผูก event ปุ่มลบ
            row.querySelector('.delete-row').addEventListener('click', () => row.remove());
            return row;
        }

        // ปุ่มเพิ่ม
        document.getElementById('add-education').addEventListener('click', () => {
            const container = document.getElementById('education-container');
            container.insertBefore(createRow('education'), document.getElementById('add-education'));
        });

        document.getElementById('add-work').addEventListener('click', () => {
            const container = document.getElementById('work-container');
            container.insertBefore(createRow('work'), document.getElementById('add-work'));
        });

        // ให้ปุ่มลบแถวแรกทำงานด้วย
        document.querySelectorAll('.delete-row').forEach(btn => {
            btn.addEventListener('click', (e) => e.target.closest('.relative').remove());
        });
    </script>


@endsection
