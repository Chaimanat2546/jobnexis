@extends('layouts.app')

@section('title', 'ผู้ประกอบการ')

@section('content')
    <div class="flex flex-col items-center justify-center p-4 overflow-x-auto border shadow bg-base-200 rounded-2xl">
        <table class="table">
            <thead>
                <tr>
                    <th>ชื่อบริษัท</th>
                    <th>เลขผู้ประกอบการ</th>
                    <th>อีเมล</th>
                    <th>ประกาศงาน</th>
                    <th>สถานะ</th>
                    <th>การทำงาน</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($providers as $p)
                    <tr>
                        <td>{{ $p->co_name ?? '-' }}</td>
                        <td>{{ $p->co_number ?? '-' }}</td>
                        <td>{{ $p->company_email ?? $p->email }}</td>
                        <td>{{ $p->open_recruitments_count }}</td>
                        <td>
                            @if ($p->is_banned)
                                <span class="px-3 py-1 text-sm text-red-600 bg-red-200 rounded-full">แบน</span>
                            @elseif ($p->email_verified_at === null)
                                <span class="px-3 py-1 text-sm text-gray-600 bg-gray-200 rounded-full">รอยืนยันอีเมล</span>
                            @else
                                <span class="px-3 py-1 text-sm text-green-600 bg-green-200 rounded-full">ใช้งานได้</span>
                            @endif
                        </td>
                        @php
                            $status = $p->is_banned
                                ? 'Banned'
                                : (is_null($p->email_verified_at)
                                    ? 'Pending'
                                    : 'Active');
                        @endphp
                        <td>
                            <div class="gap-4 join">
                                <a href="{{ route('admin.providers.recruitments.index', $p->id) }}"
                                    class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-purple-600 hover:text-white"
                                    title="à¸›à¸£à¸°à¸à¸²à¸¨à¸‡à¸²à¸™">
                                    <i class="fa-solid fa-briefcase"></i>
                                </a>
                                <a href="{{ route('provider.profile.edit', $p->id) }}"
                                    class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-blue-600 hover:text-white"
                                    title="à¹à¸à¹‰à¹„à¸‚">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @if ($status === 'Active')
                                    <form method="POST" action="{{ route('admin.providers.toggleBan', $p->id) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-red-600 hover:text-white"
                                            title="à¹à¸šà¸™">
                                            <i class="fa-solid fa-ban"></i>
                                        </button>
                                    </form>
                                @elseif ($status === 'Pending')
                                    <form method="POST" action="{{ route('admin.providers.destroy', $p->id) }}"
                                        onsubmit="return confirm('à¸¢à¸·à¸™à¸¢à¸±à¸™à¸¥à¸šà¸œà¸¹à¹‰à¹ƒà¸Šà¹‰ #{{ $p->id }} ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-red-600 hover:text-white"
                                            title="à¸¥à¸š">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.providers.toggleBan', $p->id) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="flex items-center justify-center w-10 h-10 text-gray-700 transition border border-gray-400 rounded-2xl bg-base-100 hover:bg-green-600 hover:text-white"
                                            title="à¸›à¸¥à¸”à¹à¸šà¸™">
                                            <i class="fa-solid fa-user-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-500">
                            @if (request()->filled('q'))
                                à¹„à¸¡à¹ˆà¸žà¸šà¸œà¸¹à¹‰à¹ƒà¸Šà¹‰à¸—à¸µà¹ˆà¹€à¸›à¹‡à¸™ <b>à¸œà¸¹à¹‰à¸›à¸£à¸°à¸à¸­à¸šà¸à¸²à¸£</b> à¸—à¸µà¹ˆà¸•à¸£à¸‡à¸à¸±à¸š
                                â€œ<span class="font-semibold">{{ e(request('q')) }}</span>â€
                                <a href="{{ url()->current() }}" class="ml-2 link">à¸¥à¹‰à¸²à¸‡à¸à¸²à¸£à¸„à¹‰à¸™à¸«à¸²</a>
                            @else
                                à¹„à¸¡à¹ˆà¸¡à¸µà¸œà¸¹à¹‰à¹ƒà¸Šà¹‰à¸—à¸µà¹ˆà¹€à¸›à¹‡à¸™ <b>à¸œà¸¹à¹‰à¸›à¸£à¸°à¸à¸­à¸šà¸à¸²à¸£</b> à¹ƒà¸™à¸£à¸°à¸šà¸š
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="flex justify-center mt-4">
        @if ($providers->lastPage() > 1)
            <div class="join">
                @php
                    $current = $providers->currentPage();
                    $last = $providers->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                @endphp

                @if ($start > 1)
                    <a href="{{ request()->fullUrlWithQuery(['page' => 1]) }}"
                        class="join-item btn btn-sm {{ $current == 1 ? 'btn-active' : '' }}">1</a>
                    @if ($start > 2)
                        <span class="join-item btn btn-sm btn-disabled">...</span>
                    @endif
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                        class="join-item btn btn-sm {{ $i == $current ? 'btn-active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor

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
        @endif

    </div>
@endsection

