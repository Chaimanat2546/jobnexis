@extends('layouts.app')


@section('title', 'สถาบันการศึกษา')


@section('content')
    <div class="p-4 overflow-x-auto border shadow bg-base-200 rounded-2xl">
        <table class="table">
            <thead>
                <tr>
                    <th>ชื่อสถาบัน</th>
                    <th>อีเมล</th>
                    <th>หมายเลขสถาบัน</th>
                    <th>คอร์ส</th>
                    <th>สถานะ</th>
                    <th>การทำงาน</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pagedData as $row)
                    <tr>
                        <td>{{ $row->e_name ?: '-' }}</td>
                        <td>{{ $row->institute_email ?: $row->user_email }}</td>
                        <td>{{ $row->e_number ?: '-' }}</td>
                        <td>{{ $row->courses_count ?? '-' }}</td>
                        <td>
                            @if ($row->is_banned === false && $row->email_verified_at !== null)
                                <span class="px-3 py-1 text-sm text-green-600 bg-green-200 rounded-full">ออนไลน์</span>
                            @elseif ($row->email_verified_at === null)
                                <span class="px-3 py-1 text-sm text-gray-600 bg-gray-200 rounded-full">รอยืนยัน</span>
                            @else
                                <span class="px-3 py-1 text-sm text-red-600 bg-red-200 rounded-full">ถูกแบน</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $status =
                                    $row->email_verified_at === null
                                        ? 'Pending'
                                        : ($row->is_banned
                                            ? 'Banned'
                                            : 'Active');
                            @endphp
                            <div class="flex items-center gap-2">
                                {{-- ลิงก์แก้ไข --}}
                                <a href="{{ route('admin.profile-education.edit', $row->id) }}"
                                    class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-blue-600 hover:text-white"
                                    title="แก้ไข">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                @if ($status === 'Active')
                                    {{-- แบน --}}
                                    <form method="POST" action="{{ route('admin.educations.toggleBan', $row->id) }}"
                                        class="inline-flex">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-red-600 hover:text-white"
                                            title="แบน">
                                            <i class="fa-solid fa-ban"></i>
                                        </button>
                                    </form>
                                @elseif ($status === 'Pending')
                                    {{-- ลบ (ยังไม่ยืนยันอีเมล) --}}
                                    <form method="POST" action="{{ route('admin.educations.destroy', $row->id) }}"
                                        class="inline-flex"
                                        onsubmit="return confirm('ยืนยันลบผู้ใช้ #{{ $row->id }} ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-red-600 hover:text-white"
                                            title="ลบ">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    {{-- ปลดแบน --}}
                                    <form method="POST" action="{{ route('admin.educations.toggleBan', $row->id) }}"
                                        class="inline-flex">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-green-600 hover:text-white"
                                            title="ปลดแบน">
                                            <i class="fa-solid fa-user-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
