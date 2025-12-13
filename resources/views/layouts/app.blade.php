<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Posyandu Pintar')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
<div class="flex min-h-screen">

    {{-- SIDEBAR FIX --}}
    @empty($__env->yieldContent('no_app_sidebar'))
        <div class="w-[280px] bg-white border-r border-gray-200">
            @include('partials.sidebar')
        </div>
    @endempty

    {{-- KONTEN KANAN --}}
    <div class="flex-1 flex flex-col">

        {{-- NAVBAR --}}
        @include('partials.navbar')

        {{-- CONTENT --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>

    </div>
</div>
</body>
</html>
