@if (Auth::check() && Auth::user()->role === 'jobber')
    <header>
        <div class="bg-transparent navbar">
            <div class="navbar-start"></div>
            <div class="hidden gap-20 px-6 navbar-center lg:flex rounded-3xl" id="navbar">
                <a href="/">
                    <div class="transition-transform duration-200 hover:scale-105">
                        <img src="{{ asset('image\web-image\logo.png') }}" alt="logo" class="w-full h-14">
                    </div>
                </a>
                <ul class="px-1 text-lg font-bold menu menu-horizontal ">
                    <li class="transition-transform duration-200 hover:scale-105"><a href="{{ route('courses.catalog') }}">เรียนรู้ทักษะ</a></li>
                    <li class="transition-transform duration-200 hover:scale-105"><a href="{{ route('jobber.jobs.index') }}">หางาน</a></li>
                    <li class="transition-transform duration-200 hover:scale-105"><a href="{{ route('jobber.companies.index') }}">ผู้ประกอบการ</a></li>
                    <li class="transition-transform duration-200 hover:scale-105"><a href="https://esp.informatics.buu.ac.th/2025/" target="_blank">ติดต่อเรา</a></li>
                </ul>

                <div class="dropdown dropdown-hover rounded-xl ">
                    <div tabindex="0" role="button" class="m-1 bg-transparent border-gray-300 rounded-xl btn border-1">
                        <div class="flex items-center gap-3">
                            @guest <a href="javascript:void(0);"
                                    class="text-lg font-bold bg-blue-600 rounded-xl btn text-base-100 "
                                    @click="openModal('login')">เข้าสู่ระบบ</a>
                            @endguest
                            @auth
                                <div class="avatar placeholder">
                                    <div class="flex items-center justify-center w-10 rounded-ful text-neutral-content">
                                        <i class="fa-regular fa-user" style="color: #383839;"></i>
                                    </div>
                                </div>
                                <span class="font-medium text-base-content">
                                    {{ Auth::user()->profile?->up_name ?? 'ไม่มีโปรไฟล์' }}
                                </span>
                            @endauth
                        </div>
                    </div>
                    <ul tabindex="0" class="p-2 shadow-sm dropdown-content menu bg-base-100 rounded-box z-1 w-52">
                        <li>
                            <a href="{{ route('profile-jobber.edit') }}">โปรไฟล์</a>
                        </li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="p-2 ">
                            ออกจากระบบ
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </ul>
                </div>
            </div>
            <div class="navbar-end"></div>
        </div>
    </header>
@else
    <header class="flex items-center justify-between p-4 mx-6 border-r border-gray-400 shadow bg-base-200 rounded-2xl">
        <!-- ซ้าย: แสดงชื่อหน้า -->
        <div class="text-4xl font-bold text-base-content">
            @yield('title', 'หน้าหลัก')
        </div>

        <!-- ขวา: Avatar + ชื่อผู้ใช้งาน -->
        <div class="dropdown dropdown-hover">
            <div tabindex="0" role="button" class="m-1 btn">
                <div class="flex items-center gap-3 border-gray-300 border-1">
                    @auth
                        <div class="avatar placeholder">
                            <div class="flex items-center justify-center w-10 rounded-ful text-neutral-content">
                                <i class="fa-regular fa-user" style="color: #383839;"></i>
                            </div>
                        </div>
                        @php
                            $user = Auth::user();
                            $displayName = match ($user->role) {
                                'jobber', 'admin' => $user->profile?->up_name ?? 'ไม่มีโปรไฟล์',
                                'provider' => $user->companyProfile?->co_name ?? 'ไม่มีโปรไฟล์บริษัท',
                                'education' => $user->educationProfile?->e_name ?? 'ไม่มีโปรไฟล์สถานศึกษา',
                                default => $user->name ?? 'ไม่มีโปรไฟล์',
                            };
                        @endphp

                        <span class="font-medium text-base-content">
                            {{ $displayName }}
                        </span>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-lg font-bold text-white bg-blue-600 rounded-xl btn">เข้าสู่ระบบ</a>
                    @endauth
                </div>
            </div>
            <ul tabindex="0" class="p-2 shadow-sm dropdown-content menu bg-base-100 rounded-box z-1 w-52">
                <li>
                    @php
                        $isAdmin = Auth::user()->role === 'admin';

                        $profileRoute = match (Auth::user()->role) {
                            'provider' => route('provider.profile.edit'),
                            'education' => route('profile-education.edit'),
                            default => route('profile-jobber.edit'),
                        };
                    @endphp

                    @if ($isAdmin)
                        <span>ESP BUU</span>
                    @else
                        <a href="{{ $profileRoute }}">โปรไฟล์</a>
                    @endif
                </li>
            </ul>
        </div>
    </header>
@endif
