<aside class="bg-base-200 w-[230px] p-4 flex flex-col items-center shadow border-r border-gray-300 min-h-[calc(100vh-4rem)]">
    <a href="/">
        <img src="{{ asset('image/web-image/logo.png') }}" alt="logo" class="w-auto h-12 mb-6">
    </a>


    <ul class="w-full gap-2 menu menu-vertical text-base-content">
        @if (Auth::check() && Auth::user()->role === 'admin')
            <li>
                <a href="{{ url('admin/dashboard') }}"
                    class="flex items-center {{ request()->is('education/dashboard') ? 'text-blue-600' : '' }}">
                    <i
                        class="fa-solid fa-tachometer-alt w-5 text-blue-600 text-center mr-1 {{ request()->is('education/dashboard') ? 'text-blue-600' : '' }}"></i>
                    แดชบอร์ด
                </a>
            </li>
            <li>
                <a href="{{ url('/education/courses') }}"
                    class="flex items-center {{ request()->is('education/courses') ? 'text-blue-600' : '' }}">
                    <i
                        class="fa-solid fa-graduation-cap w-5 text-blue-600 text-center mr-1 {{ request()->is('education/courses') ? 'text-blue-600' : '' }}"></i>
                    คอร์สอบรม
                </a>
            </li>
            <li>
                <a href="{{ url('#') }}"
                    class="flex items-center {{ request()->is('education/courses') ? 'text-blue-600' : '' }}">
                    <i
                        class="fa-solid fa-clipboard-check w-5 text-blue-600 text-center mr-1 {{ request()->is('education/courses') ? 'text-blue-600' : '' }}"></i>
                    งาน
                </a>
            </li>
            <li>
                <a href="{{ url('admin/jobber') }}"
                    class="flex items-center {{ request()->is('education/courses') ? 'text-blue-600' : '' }}">
                    <i
                        class="fa-solid fa-user w-5 text-blue-600 text-center mr-1 {{ request()->is('education/courses') ? 'text-blue-600' : '' }}"></i>
                    ผู้สมัครงาน
                </a>
            </li>
            <li>
                <a href="{{ url('admin/providers') }}"
                    class="flex items-center {{ request()->is('education/courses') ? 'text-blue-600' : '' }}">
                    <i
                        class="fa-solid fa-building w-5 text-blue-600 text-center mr-1 {{ request()->is('education/courses') ? 'text-blue-600' : '' }}"></i>
                    ผู้ประกอบการ
                </a>
            </li>
            <li>
                <a href="{{ url('admin/education') }}"
                    class="flex items-center {{ request()->is('education/courses') ? 'text-blue-600' : '' }}">
                    <i
                        class="fa-solid fa-building-columns w-5 text-blue-600 text-center mr-1 {{ request()->is('education/courses') ? 'text-blue-600' : '' }}"></i>
                    สถาบันการศึกษา
                </a>
            </li>
            <li>
                <a href="{{ url('/logout') }}" class="flex items-center">
                    <i class="w-5 mr-1 text-center text-blue-600 fa-solid fa-sign-out-alt"></i>
                    ออกจากระบบ
                </a>
            </li>
        @elseif (Auth::check() && Auth::user()->role === 'education')
             <li>
                <a href="{{ url('education/dashboard') }}" class="flex items-center {{ request()->is('education/dashboard') ? 'text-blue-600' : '' }}">
                    <i class="fa-solid fa-tachometer-alt w-5 text-blue-600 text-center mr-1 {{ request()->is('education/dashboard') ? 'text-blue-600' : '' }}"></i>
                    แดชบอร์ด
                </a>
            </li>
            <li>
                <a href="{{ url('/education/courses') }}" class="flex items-center {{ request()->is('education/courses') ? 'text-blue-600' : '' }}">
                    <i class="fa-solid fa-graduation-cap w-5 text-blue-600 text-center mr-1 {{ request()->is('education/courses') ? 'text-blue-600' : '' }}"></i>
                    คอร์สอบรม
                </a>
            </li>
            <li>
                <a href="{{ url('/logout') }}" class="flex items-center">
                    <i class="w-5 mr-1 text-center text-blue-600 fa-solid fa-sign-out-alt"></i>
                    ออกจากระบบ
                </a>
            </li>
        @endif
    </ul>
</aside>
