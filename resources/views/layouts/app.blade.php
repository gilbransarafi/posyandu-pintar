<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Posyandu Pintar')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
<div class="flex min-h-screen relative">

    {{-- SIDEBAR DESKTOP --}}
    @empty($__env->yieldContent('no_app_sidebar'))
        <div class="hidden lg:block w-[280px] bg-white border-r border-gray-200">
            @include('partials.sidebar')
        </div>

        {{-- SIDEBAR MOBILE (drawer) --}}
        <div id="sidebar-backdrop" class="hidden fixed inset-0 bg-black/40 z-30 lg:hidden"></div>
        <div id="sidebar-panel-mobile"
             class="fixed inset-y-0 left-0 z-40 w-72 max-w-[90vw] bg-white border-r border-gray-200 transform -translate-x-full transition-transform duration-200 lg:hidden">
            @include('partials.sidebar')
        </div>
    @endempty

    {{-- KONTEN KANAN --}}
    <div class="flex-1 flex flex-col min-h-screen">

        {{-- NAVBAR --}}
        @include('partials.navbar')

        {{-- CONTENT --}}
        <main class="flex-1 p-4 sm:p-6 overflow-y-auto">
            @yield('content')
        </main>

    </div>
</div>

<script>
    (() => {
        const toggleBtn = document.getElementById('sidebar-toggle');
        const mobilePanel = document.getElementById('sidebar-panel-mobile');
        const backdrop = document.getElementById('sidebar-backdrop');

        if (!toggleBtn || !mobilePanel || !backdrop) return;

        const open = () => {
            mobilePanel.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        };

        const close = () => {
            mobilePanel.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        };

        toggleBtn.addEventListener('click', () => {
            const isHidden = mobilePanel.classList.contains('-translate-x-full');
            isHidden ? open() : close();
        });

        backdrop.addEventListener('click', close);
    })();
</script>
</body>
</html>
