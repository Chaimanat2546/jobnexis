<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mb-4 text-lg font-semibold">ยินดีต้อนรับ Admin!</h3>
                    <p class="mb-4">นี่คือหน้า Admin Dashboard ที่เฉพาะ Admin เท่านั้นที่เข้าถึงได้</p>

                    <div class="grid grid-cols-1 gap-4 mt-6 md:grid-cols-3">
                        <div class="p-4 bg-blue-100 rounded-lg">
                            <h4 class="font-semibold text-blue-800">จัดการผู้ใช้</h4>
                            <p class="text-sm text-blue-600">ดูรายชื่อและจัดการผู้ใช้ทั้งหมด</p>
                        </div>
                        <div class="p-4 bg-green-100 rounded-lg">
                            <h4 class="font-semibold text-green-800">รายงาน</h4>
                            <p class="text-sm text-green-600">ดูรายงานและสถิติต่างๆ</p>
                        </div>
                        <div class="p-4 bg-purple-100 rounded-lg">
                            <h4 class="font-semibold text-purple-800">ตั้งค่าระบบ</h4>
                            <p class="text-sm text-purple-600">จัดการการตั้งค่าของระบบ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
