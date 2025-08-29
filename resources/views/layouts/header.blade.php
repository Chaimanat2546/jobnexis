<header class="flex items-center justify-between p-4 mx-6 border-r border-gray-400 shadow bg-base-200 rounded-2xl">
    <!-- ซ้าย: แสดงชื่อหน้า -->
    <div class="text-4xl font-bold text-base-content">
        @yield('title', 'หน้าหลัก')
    </div>

    <!-- ขวา: Avatar + ชื่อผู้ใช้งาน -->
    <div class="dropdown dropdown-hover">
        <div tabindex="0" role="button" class="m-1 btn">
            <div class="flex items-center gap-3">
                @auth
                    <div class="avatar">
                        <div class="w-10 rounded-full">
                            <img src="{{ Auth::user()->profile_image ?? 'https://i.pravatar.cc/150?u=default' }}"
                                alt="Profile">
                        </div>
                    </div>
                    <span class="font-medium text-base-content">
                        {{ Auth::user()->name ?? 'ชัยมนัส แอบสุข' }}
                    </span>
                @else
                    <a href="{{ route('login') }}"
                        class="text-lg font-bold text-white bg-blue-600 rounded-xl btn">เข้าสู่ระบบ</a>
                @endauth
            </div>
        </div>
        <ul tabindex="0" class="p-2 shadow-sm dropdown-content menu bg-base-100 rounded-box z-1 w-52">
            <li><a>โปรไฟล์</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        ลงชื่อออก
                    </button>
                </form>
            </li>
        </ul>
    </div>
</header>
