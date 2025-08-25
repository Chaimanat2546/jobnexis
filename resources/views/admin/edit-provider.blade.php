@extends('layouts.app')

@section('title', 'แก้ไขโปรไฟล์ผู้ประกอบการ')

@section('content')
<div class="flex flex-col gap-4 p-4 border shadow bg-base-200 rounded-2xl">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold">โปรไฟล์ผู้ประกอบการ</h1>
            <p class="text-sm text-gray-500">เพิ่ม/แก้ไขข้อมูลบริษัท</p>
        </div>
        @if(!empty($isAdminEditing) && $isAdminEditing)
            <div class="px-3 py-1 text-sm rounded-full bg-amber-100 text-amber-700">
                โหมดผู้ดูแลระบบ: กำลังแก้ไขโปรไฟล์ของผู้ใช้ ID {{ $targetUserId }}
            </div>
        @endif
    </div>

    @if (session('success'))
        <div class="p-3 text-green-700 bg-green-100 rounded">{{ session('success') }}</div>
    @endif

    @php
        $action = (!empty($isAdminEditing) && $isAdminEditing)
            ? route('provider.profile.store', ['userId' => $targetUserId])
            : route('provider.profile.store');
        $action = route('provider.profile.store', ['userId' => $targetUserId]);
    @endphp

    <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="flex flex-col gap-6">
        @csrf
         <input type="hidden" name="target_user_id" value="{{ $targetUserId }}">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <fieldset class="fieldset">
                <legend class="mb-1 fieldset-legend">ชื่อบริษัท *</legend>
                <input name="co_name" type="text" required
                       value="{{ old('co_name', $profile->co_name ?? '') }}"
                       class="w-full pl-2 border border-gray-300 input" placeholder="ชื่อบริษัท" />
                @error('co_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </fieldset>

            <fieldset class="fieldset">
                <legend class="mb-1 fieldset-legend">อีเมลบริษัท</legend>
                <input name="co_email" type="email"
                       value="{{ old('co_email', $profile->co_email ?? '') }}"
                       class="w-full pl-2 border border-gray-300 input" placeholder="company@example.com" />
                @error('co_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </fieldset>

            <fieldset class="fieldset">
                <legend class="mb-1 fieldset-legend">เบอร์โทร</legend>
                <input name="co_phone" type="number"
                       value="{{ old('co_phone', $profile->co_phone ?? '') }}"
                       class="w-full pl-2 border border-gray-300 input" placeholder="เช่น 0812345678" />
                @error('co_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </fieldset>

            <fieldset class="fieldset">
                <legend class="mb-1 fieldset-legend">วันก่อตั้ง / วันจดทะเบียน</legend>
                <input name="co_birthday" type="date"
                       value="{{ old('co_birthday', optional($profile->co_birthday ?? null)->format('Y-m-d') ?? $profile->co_birthday ?? '') }}"
                       class="w-full pl-2 border border-gray-300 input" />
                @error('co_birthday') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </fieldset>

            <fieldset class="fieldset">
                <legend class="mb-1 fieldset-legend">ประเภทกิจการ</legend>
                <input name="co_type" type="text"
                       value="{{ old('co_type', $profile->co_type ?? '') }}"
                       class="w-full pl-2 border border-gray-300 input" placeholder="เช่น บริษัทจำกัด, หจก., บุคคลธรรมดา" />
                @error('co_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </fieldset>

            <fieldset class="fieldset">
                <legend class="mb-1 fieldset-legend">เลขผู้ประกอบการ / เลขนิติบุคคล</legend>
                <input name="co_number" type="text"
                       value="{{ old('co_number', $profile->co_number ?? '') }}"
                       class="w-full pl-2 border border-gray-300 input" placeholder="เช่น 0105555xxxxx" />
                @error('co_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </fieldset>

            <fieldset class="fieldset">
                <legend class="mb-1 fieldset-legend">จำนวนพนักงาน</legend>
                <input name="co_jobber_amount" type="number" min="0"
                       value="{{ old('co_jobber_amount', $profile->co_jobber_amount ?? '') }}"
                       class="w-full pl-2 border border-gray-300 input" placeholder="เช่น 10" />
                @error('co_jobber_amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </fieldset>

            <fieldset class="col-span-1 md:col-span-2 fieldset">
                <legend class="mb-1 fieldset-legend">ที่อยู่</legend>
                <input name="co_address" type="text"
                       value="{{ old('co_address', $profile->co_address ?? '') }}"
                       class="w-full pl-2 border border-gray-300 input" placeholder="บ้านเลขที่, ถนน, แขวง/ตำบล, เขต/อำเภอ" />
                @error('co_address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </fieldset>

            <fieldset class="fieldset">
                                <legend for="co_province" class="mb-1 fieldset-legend">จังหวัด</legend>
                                <select name="co_province" id="co_province" class="pl-2 border border-gray-300 select w-72">
                                    <option value="">-- เลือกจังหวัด --</option>
                                    @php
                                        $provinces = [
                                            'กรุงเทพมหานคร',
                                            'กระบี่',
                                            'กาญจนบุรี',
                                            'กาฬสินธุ์',
                                            'กำแพงเพชร',
                                            'ขอนแก่น',
                                            'จันทบุรี',
                                            'ฉะเชิงเทรา',
                                            'ชลบุรี',
                                            'ชัยนาท',
                                            'ชัยภูมิ',
                                            'ชุมพร',
                                            'เชียงราย',
                                            'เชียงใหม่',
                                            'ตรัง',
                                            'ตราด',
                                            'ตาก',
                                            'นครนายก',
                                            'นครปฐม',
                                            'นครพนม',
                                            'นครราชสีมา',
                                            'นครศรีธรรมราช',
                                            'นครสวรรค์',
                                            'นนทบุรี',
                                            'นราธิวาส',
                                            'น่าน',
                                            'บึงกาฬ',
                                            'บุรีรัมย์',
                                            'ปทุมธานี',
                                            'ประจวบคีรีขันธ์',
                                            'ปราจีนบุรี',
                                            'ปัตตานี',
                                            'พระนครศรีอยุธยา',
                                            'พังงา',
                                            'พัทลุง',
                                            'พิจิตร',
                                            'พิษณุโลก',
                                            'เพชรบุรี',
                                            'เพชรบูรณ์',
                                            'แพร่',
                                            'ภูเก็ต',
                                            'มหาสารคาม',
                                            'มุกดาหาร',
                                            'แม่ฮ่องสอน',
                                            'ยโสธร',
                                            'ยะลา',
                                            'ร้อยเอ็ด',
                                            'ระนอง',
                                            'ระยอง',
                                            'ราชบุรี',
                                            'ลพบุรี',
                                            'ลำปาง',
                                            'ลำพูน',
                                            'ศรีสะเกษ',
                                            'สกลนคร',
                                            'สงขลา',
                                            'สตูล',
                                            'สมุทรปราการ',
                                            'สมุทรสงคราม',
                                            'สมุทรสาคร',
                                            'สระแก้ว',
                                            'สระบุรี',
                                            'สิงห์บุรี',
                                            'สุโขทัย',
                                            'สุพรรณบุรี',
                                            'สุราษฎร์ธานี',
                                            'สุรินทร์',
                                            'หนองคาย',
                                            'หนองบัวลำภู',
                                            'อ่างทอง',
                                            'อำนาจเจริญ',
                                            'อุดรธานี',
                                            'อุตรดิตถ์',
                                            'อุทัยธานี',
                                            'อุบลราชธานี',
                                        ];
                                    @endphp

                                    @foreach ($provinces as $province)
                                        <option value="{{ $province }}"
                                            {{ old('co_province', $profile->co_province ?? '') == $province ? 'selected' : '' }}>
                                            {{ $province }}
                                        </option>
                                    @endforeach
                                </select>
                            </fieldset>
            <fieldset class="col-span-1 md:col-span-2 fieldset">
                <legend class="mb-1 fieldset-legend">รายละเอียดบริษัท</legend>
                <textarea name="co_details" rows="5" class="w-full pl-2 border border-gray-300 textarea"
                          placeholder="แนะนำบริษัท สินค้า/บริการ ฯลฯ">{{ old('co_details', $profile->co_details ?? '') }}</textarea>
                @error('co_details') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </fieldset>
        </div>

        {{-- ========== ส่วนอัปโหลดรูป (อยู่ด้านล่างสุดตามที่ขอ) ========== --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <fieldset class="fieldset">
                <legend class="mb-1 fieldset-legend">รูปโปรไฟล์บริษัท</legend>

                @php
                    $profileImg = !empty($profile->co_profile_img)
                        ? asset('storage/'.$profile->co_profile_img)
                        : null;
                @endphp

                @if ($profileImg)
                    <img src="{{ $profileImg }}" alt="company profile" class="object-cover w-48 h-48 mb-2 rounded-xl" />
                @endif

                <input name="co_profile_img" type="file" accept="image/*"
                       class="w-full max-w-md file-input file-input-bordered"
                       onchange="previewImage(event, 'previewProfileImg')" />
                @error('co_profile_img') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                <img id="previewProfileImg" class="hidden object-cover w-48 h-48 mt-2 rounded-xl" />
            </fieldset>

            <fieldset class="fieldset">
                <legend class="mb-1 fieldset-legend">รูปแบนเนอร์</legend>

                @php
                    $bannerImg = !empty($profile->co_banner_img)
                        ? asset('storage/'.$profile->co_banner_img)
                        : null;
                @endphp

                @if ($bannerImg)
                    <img src="{{ $bannerImg }}" alt="company banner" class="object-cover w-full h-40 max-w-xl mb-2 rounded-xl" />
                @endif

                <input name="co_banner_img" type="file" accept="image/*"
                       class="w-full max-w-md file-input file-input-bordered"
                       onchange="previewImage(event, 'previewBannerImg')" />
                @error('co_banner_img') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                <img id="previewBannerImg" class="hidden object-cover w-full h-40 max-w-xl mt-2 rounded-xl" />
            </fieldset>
        </div>
        {{-- ============================================================ --}}

        <div class="flex items-center gap-2">
            <button class="px-6 py-2 text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700">บันทึก</button>
            <a href="{{ url()->previous() }}" class="px-6 py-2 btn">ยกเลิก</a>
        </div>
    </form>
</div>

{{-- Preview script --}}
<script>
function previewImage(evt, previewId) {
    const input = evt.target;
    const img = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
