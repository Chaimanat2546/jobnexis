<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth Modal - Fixed Validation</title>
    @vite('resources/css/app.css')
</head>

<body class="antialiased bg-gray-100">
    <div x-data="authModal()" x-init="init()" class="flex items-center justify-center min-h-screen">

        <!-- Trigger Button -->
        {{-- <button @click="openModal('login')"
            class="px-6 py-3 text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Sign In
        </button> --}}
        <!-- ถ้ายังไม่ login -->
        @guest
            <div class="flex justify-center gap-4 mb-8">
                <button @click="openRegister('jobber')"
                    class="px-6 py-3 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">สมัครเป็นบุคคลทั่วไป</button>
                <button @click="openRegister('provider')"
                    class="px-6 py-3 text-white bg-green-600 rounded-lg hover:bg-green-700">สมัครเป็นผู้ประกอบการ</button>
                <button @click="openRegister('education')"
                    class="px-6 py-3 text-white bg-yellow-500 rounded-lg hover:bg-yellow-600">สมัครเป็นบุคลากรสถานศึกษา</button>
            </div>
        @endguest

        <!-- ถ้า login แล้ว -->
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-6 py-3 text-white transition-colors bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Logout
                </button>
            </form>
        @endauth


        <!-- Modal Overlay -->
        <div x-show="showModal" x-cloak x-transition.opacity.duration.300ms
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">

            <!-- Modal Content -->
            <div x-transition.scale.origin.center.duration.300ms
                class="relative w-full max-w-md mx-4 bg-white shadow-2xl rounded-xl">

                <!-- Close Button -->
                <button @click="closeModal()"
                    class="absolute p-1 text-gray-400 transition-colors rounded-full top-4 right-4 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <!-- Modal Body -->
                <div class="p-8">
                    <!-- Login Form -->
                    <template x-if="currentModal === 'login'">
                        <div>
                            <h2 class="mb-6 text-2xl font-bold text-center text-gray-900">Welcome Back</h2>

                            <!-- Success message สำหรับ password reset -->
                            @if (session('status') === 'password-updated')
                                <div
                                    class="p-4 mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg">
                                    Password updated successfully! You can now log in with your new password.
                                </div>
                            @endif

                            {{-- <!-- General Error Message for Login -->
                            @if ($errors->any() && (request()->routeIs('login') || old('_token')))
                                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-lg">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}

                            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="form_type" value="login">
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email"
                                        class="block w-full mt-1 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 {{ session('errors') && old('form_type') === 'login' && session('errors')->has('email') ? 'border-red-500' : '' }}"
                                        :value="old('email')" required autofocus />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password" :value="__('Password')" />
                                    <x-text-input id="password" name="password" type="password"
                                        class="block w-full mt-1 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 {{ session('errors') && old('form_type') === 'login' && session('errors')->has('password') ? 'border-red-500' : '' }}"
                                        required />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-between">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="remember"
                                            class="text-indigo-600 border-gray-300 rounded shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                    </label>
                                    <button type="button" @click="switchModal('forgot')"
                                        class="text-sm text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline">
                                        Forgot Password?
                                    </button>
                                </div>

                                <x-primary-button class="justify-center w-full py-3">
                                    {{ __('Sign In') }}
                                </x-primary-button>
                            </form>

                            <div class="mt-6 text-center">
                                <p class="text-sm text-gray-600">
                                    Don't have an account?
                                    <button @click="switchModal('register')"
                                        class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline">
                                        Sign Up
                                    </button>
                                </p>
                            </div>
                        </div>
                    </template>

                    <!-- Register Form -->
                    <template x-if="currentModal === 'register'">
                        <div>
                            <h2 class="mb-6 text-2xl font-bold text-center text-gray-900"
                                x-text="registerRole === 'jobber' ? 'สมัครเป็นบุคคลทั่วไป' : (registerRole === 'provider' ? 'สมัครเป็นผู้ประกอบการ' : 'สมัครเป็นบุคลากรสถานศึกษา')">
                            </h2>

                            <!-- General Error Message for Register -->
                            @if ($errors->any() && request()->routeIs('register'))
                                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-lg">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="form_type" value="register">
                                <input type="hidden" name="role" :value="registerRole">

                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email"
                                        class="block w-full mt-1 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 {{ session('errors') && old('form_type') === 'register' && session('errors')->has('email') ? 'border-red-500' : '' }}"
                                        :value="old('email')" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password" :value="__('Password')" />
                                    <x-text-input id="password" name="password" type="password"
                                        class="block w-full mt-1 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 {{ session('errors') && old('form_type') === 'register' && session('errors')->has('password') ? 'border-red-500' : '' }}"
                                        required />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-text-input id="password_confirmation" name="password_confirmation"
                                        type="password"
                                        class="block w-full mt-1 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 {{ session('errors') && old('form_type') === 'register' && session('errors')->has('password_confirmation') ? 'border-red-500' : '' }}"
                                        required />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <x-primary-button class="justify-center w-full py-3">
                                    {{ __('Create Account') }}
                                </x-primary-button>
                            </form>

                            <div class="mt-6 text-center">
                                <p class="text-sm text-gray-600">
                                    Already have an account?
                                    <button @click="switchModal('login')"
                                        class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline">
                                        Sign In
                                    </button>
                                </p>
                            </div>
                        </div>
                    </template>

                    <!-- Forgot Password Form -->
                    <template x-if="currentModal === 'forgot'">
                        <div>
                            <h2 class="mb-6 text-2xl font-bold text-center text-gray-900">Reset Password</h2>

                            @if (session('status'))
                                <div
                                    class="p-4 mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <!-- General Error Message for Forgot Password -->
                            @if ($errors->any() && request()->routeIs('password.email'))
                                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-lg">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="form_type" value="forgot">
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email"
                                        class="block w-full mt-1 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 {{ session('errors') && old('form_type') === 'password.email' && session('errors')->has('email') ? 'border-red-500' : '' }}"
                                        :value="old('email')" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <x-primary-button class="justify-center w-full py-3">
                                    {{ __('Send Reset Link') }}
                                </x-primary-button>
                            </form>

                            <div class="mt-6 text-center">
                                <p class="text-sm text-gray-600">
                                    Remember your password?
                                    <button @click="switchModal('login')"
                                        class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline">
                                        Sign In
                                    </button>
                                </p>
                            </div>
                        </div>
                    </template>

                    <!-- Email Verification -->
                    <template x-if="currentModal === 'verify'">
                        <div>
                            <h2 class="mb-6 text-2xl font-bold text-center text-indigo-700">Verify Your Email</h2>

                            @if (session('status') === 'verification-link-sent')
                                <div
                                    class="p-4 mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg">
                                    A new verification link has been sent to your email address.
                                </div>
                            @endif

                            <!-- General Error Message for Verification -->
                            @if ($errors->any() && request()->routeIs('verification.send'))
                                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-lg">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="text-center">
                                <div class="mb-6">
                                    <svg class="w-16 h-16 mx-auto text-indigo-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="mb-6 text-gray-600">
                                    Please check your email for a verification link. If you didn't receive it, we can
                                    send you another.
                                </p>

                                <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="form_type" value="verify">
                                    <x-primary-button class="justify-center w-full py-3">
                                        Resend Verification Email
                                    </x-primary-button>
                                </form>

                                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                                    @csrf
                                    <button type="submit"
                                        class="text-sm text-gray-500 hover:text-gray-700 focus:outline-none focus:underline">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </template>

                    <!-- Reset Password Form -->
                    <template x-if="currentModal === 'reset'">
                        <div>
                            <h2 class="mb-6 text-2xl font-bold text-center text-gray-900">Set New Password</h2>

                            <!-- General Error Message for Reset Password -->
                            @if ($errors->any() && request()->routeIs('password.store'))
                                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-lg">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="form_type" value="reset">

                                <!-- ใช้ token จาก URL parameter หรือ session -->
                                @if (request('token'))
                                    <input type="hidden" name="token" value="{{ request('token') }}" />
                                @else
                                    <input type="hidden" name="token"
                                        value="{{ session('passwordResetToken') }}" />
                                @endif

                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email"
                                        class="block w-full mt-1 rounded-lg bg-gray-50 border-gray-300 {{ session('errors') && old('form_type') === 'password.store' && session('errors')->has('email') ? 'border-red-500' : '' }}"
                                        :value="request('email') ?: session('passwordResetEmail')" readonly />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password" :value="__('New Password')" />
                                    <x-text-input id="password" name="password" type="password"
                                        class="block w-full mt-1 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 {{ session('errors') && old('form_type') === 'password.store' && session('errors')->has('password') ? 'border-red-500' : '' }}"
                                        required autofocus />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-text-input id="password_confirmation" name="password_confirmation"
                                        type="password"
                                        class="block w-full mt-1 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 {{ session('errors') && old('form_type') === 'password.store' && session('errors')->has('password_confirmation') ? 'border-red-500' : '' }}"
                                        required />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <x-primary-button class="justify-center w-full py-3">
                                    {{ __('Update Password') }}
                                </x-primary-button>
                            </form>

                            <div class="mt-6 text-center">
                                <p class="text-sm text-gray-600">
                                    Back to
                                    <button @click="switchModal('login')"
                                        class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline">
                                        Sign In
                                    </button>
                                </p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Script -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        function authModal() {
            return {
                showModal: false,
                currentModal: 'login',
                registerRole: 'jobber', // default

                openRegister(role) {
                    this.registerRole = role;
                    this.currentModal = 'register';
                    this.showModal = true;
                    document.body.style.overflow = 'hidden';
                },
                init() {
                    console.log('authModal initialized');

                    // ตรวจสอบ validation errors และกำหนด modal type
                    let hasErrors = @json($errors->any());
                    let routeName = @json(request()->route() ? request()->route()->getName() : null);
                    let formType = @json(old('form_type', null));

                    console.log('Has errors:', hasErrors);
                    console.log('Route name:', routeName);
                    console.log('Form type:', formType);

                    if (hasErrors) {
                        this.showModal = true;

                        // ใช้ form_type จาก old input ก่อน แล้วค่อย fallback ไป route name
                        if (formType) {
                            switch (formType) {
                                case 'login':
                                    this.currentModal = 'login';
                                    break;
                                case 'register':
                                    this.currentModal = 'register';
                                    break;
                                case 'forgot':
                                    this.currentModal = 'forgot';
                                    break;
                                case 'reset':
                                    this.currentModal = 'reset';
                                    break;
                                case 'verify':
                                    this.currentModal = 'verify';
                                    break;
                                default:
                                    this.currentModal = 'login';
                            }
                        } else {
                            // Fallback ไป route name
                            switch (routeName) {
                                case 'login':
                                    this.currentModal = 'login';
                                    break;
                                case 'register':
                                    this.currentModal = 'register';
                                    break;
                                case 'password.email':
                                    this.currentModal = 'forgot';
                                    break;
                                case 'password.reset':
                                    this.currentModal = 'reset';
                                    break;
                                case 'verification.send':
                                    this.currentModal = 'verify';
                                    break;
                                default:
                                    this.currentModal = 'login';
                            }
                        }

                        console.log('Opening modal due to errors:', this.currentModal);
                        document.body.style.overflow = 'hidden';
                    } else {
                        // ใช้ค่าจาก session หากไม่มี errors
                        this.showModal = @json(session('showAuthModal', false));
                        this.currentModal = @json(session('authForm', 'login'));
                    }

                    // ตรวจสอบ URL parameters สำหรับ reset password
                    const urlParams = new URLSearchParams(window.location.search);
                    const token = urlParams.get('token');

                    if (window.location.pathname.includes('/reset-password/') && token) {
                        console.log('Reset password URL detected with token');
                        this.openModal('reset');
                    }
                    if (routeName === 'password.reset') {
                        this.showModal = true;
                        this.currentModal = 'reset';
                        document.body.style.overflow = 'hidden';
                        return;
                    }
                    console.log('Final modal state - showModal:', this.showModal, 'currentModal:', this.currentModal);
                },

                openModal(modalType) {
                    console.log('Opening modal:', modalType);
                    this.currentModal = modalType;
                    this.showModal = true;
                    document.body.style.overflow = 'hidden';
                },

                closeModal() {
                    console.log('Closing modal');
                    this.showModal = false;
                    document.body.style.overflow = 'auto';

                    // ลบ parameters จาก URL
                    if (window.location.pathname.includes('/reset-password/')) {
                        window.history.replaceState({}, '', '/');
                    }
                },

                switchModal(modalType) {
                    console.log('Switching to modal:', modalType);
                    this.currentModal = modalType;
                }
            }
        }
    </script>
</body>

</html>
