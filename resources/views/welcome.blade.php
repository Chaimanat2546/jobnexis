<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Modal</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
</head>

<body class="antialiased bg-gray-100">
    <div x-data="{ showLogin: {{ session('showLoginModal') ? 'true' : 'false' }} }" class="flex items-center justify-center min-h-screen">


        <!-- ปุ่มเปิด Modal -->
        <button @click="showLogin = true" class="px-4 py-2 text-white bg-indigo-600 rounded">
            Login
        </button>

        <!-- Modal -->
        <div x-show="showLogin" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="relative w-full max-w-md p-6 bg-white rounded-lg">
                <!-- ปุ่มปิด -->
                <button @click="showLogin = false" class="absolute text-gray-500 top-2 right-2">&times;</button>

                <!-- ฟอร์ม Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h2 class="mb-4 text-xl font-semibold">Login</h2>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block w-full mt-1" type="email" name="email"
                            :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                            autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500"
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-3">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
