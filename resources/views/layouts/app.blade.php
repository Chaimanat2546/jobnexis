{{-- filepath: e:\Project\jobnexis\resources\views\layouts\app.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JobNexis')</title>

    {{-- DaisyUI + Tailwind --}}
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- ฟอนต์ Kanit --}}
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/2412bed399.js" crossorigin="anonymous"></script>

    {{-- AlpineJS --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Kanit', sans-serif; }
    </style>
</head>

<body class="h-full min-h-screen p-6 bg-gray-200">
    <div class="flex">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="flex flex-col flex-1">
            {{-- Header --}}
            @include('layouts.header')

            {{-- Content --}}
            <main class="px-6 pt-6 text-md">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
