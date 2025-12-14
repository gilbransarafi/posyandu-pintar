<aside class="h-screen sticky top-0 flex flex-col">
    @php
        $logoFile = file_exists(public_path('images/logo-posyandu.png'))
            ? asset('images/logo-posyandu.png')
            : (file_exists(public_path('images/Logo Posyandu.png'))
                ? asset('images/Logo Posyandu.png')
                : null);

        $user = auth()->user();
        $userName = $user->name ?? 'admin';
        $initial = strtoupper(substr($userName, 0, 1));

        $topGender = $topGender ?? [];
    @endphp

    <div class="sticky top-0 h-[calc(100vh-48px)] flex flex-col">

        {{-- Header --}}
        <div class="px-6 py-5 flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl bg-indigo-50 flex items-center justify-center overflow-hidden">
                @if ($logoFile)
                    <img src="{{ $logoFile }}" class="h-8 w-8 object-contain" alt="Logo">
                @else
                    <span class="text-indigo-600 font-semibold text-xs">Logo</span>
                @endif
            </div>
            <div>
                <p class="text-[11px] uppercase tracking-wide font-semibold text-indigo-600">Posyandu</p>
                <p class="text-base font-semibold text-gray-900 leading-tight">Dashboard</p>
            </div>
        </div>

        {{-- Menu --}}
        <div class="px-6 pb-4 flex-1 overflow-y-auto">
            <p class="text-xs font-semibold text-gray-400 uppercase mb-3">Platform</p>

            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-gray-100 font-semibold">
                    Dashboard
                </a>

                @foreach ($topGender as $stat)
                    <a href="#{{ $stat['anchor'] ?? 'indikator-' . $stat['no'] }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                        {{ $stat['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-gray-100 flex items-center justify-center font-semibold">
                    {{ $initial }}
                </div>
                <div>
                    <p class="text-sm font-semibold">{{ $userName }}</p>
                    <p class="text-xs text-gray-500">admin</p>
                </div>
            </div>
        </div>

    </div>
</aside>
