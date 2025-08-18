@extends('layouts.app')

@section('title', 'ผู้สมัครงาน')

@section('content')
    <div class="flex items-center justify-between p-4 overflow-x-auto border shadow bg-base-200 rounded-2xl">
        <table class="table">
            <thead>
                <tr>
                    <th>ไอดี</th>
                    <th>ชื่อ-สกุล</th>
                    <th>อีเมล</th>
                    <th>สถานะ</th>
                    <th>การทำงาน</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pagedData as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>
                            @if ($user['status'] === 'Active')
                                <span class="px-3 py-1 text-sm text-green-600 bg-green-200 rounded-full">ออนไลน์</span>
                            @elseif ($user['status'] === 'Pending')
                                <span class="px-3 py-1 text-sm text-gray-600 bg-gray-200 rounded-full">รอยืนยันตัวตน</span>
                            @else
                                <span class="px-3 py-1 text-sm text-red-600 bg-red-200 rounded-full">ถูกแบน</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <a href="#"
                                    class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-blue-600 hover:text-white">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </a>
                                @if ($user['status'] === 'Active')
                                    <a href="#"
                                        class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-red-600 hover:text-white">
                                        <i class="fa-solid fa-ban"></i>
                                    </a>
                                @elseif ($user['status'] === 'Pending')
                                    <a href="#"
                                        class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-red-600 hover:text-white">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                @else
                                    <a href="#"
                                        class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-green-600 hover:text-white">
                                        <i class="fa-solid fa-user-check"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Smart Pagination --}}
    <div class="flex justify-center mt-4">
        <div class="join">
            @php
                $current = $pagedData->currentPage();
                $last = $pagedData->lastPage();
                $start = max(1, $current - 2);
                $end = min($last, $current + 2);
            @endphp

            {{-- ปุ่มหน้าแรก --}}
            @if ($start > 1)
                <a href="{{ request()->fullUrlWithQuery(['page' => 1]) }}"
                    class="join-item btn btn-sm {{ $current == 1 ? 'btn-active' : '' }}">1</a>
                @if ($start > 2)
                    <span class="join-item btn btn-sm btn-disabled">...</span>
                @endif
            @endif

            {{-- ปุ่มช่วงกลาง --}}
            @for ($i = $start; $i <= $end; $i++)
                <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                    class="join-item btn btn-sm {{ $i == $current ? 'btn-active' : '' }}">
                    {{ $i }}
                </a>
            @endfor

            {{-- ปุ่มหน้าสุดท้าย --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <span class="join-item btn btn-sm btn-disabled">...</span>
                @endif
                <a href="{{ request()->fullUrlWithQuery(['page' => $last]) }}"
                    class="join-item btn btn-sm {{ $current == $last ? 'btn-active' : '' }}">
                    {{ $last }}
                </a>
            @endif
        </div>
    </div>
@endsection
