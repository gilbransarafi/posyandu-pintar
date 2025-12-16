<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Posyandu Pintar</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50">
    @php
        $logoFile = file_exists(public_path('images/logo-posyandu.png'))
            ? asset('images/logo-posyandu.png')
            : (file_exists(public_path('images/Logo Posyandu.png'))
                ? asset('images/Logo Posyandu.png')
                : null);

        $user = auth()->user();
        $userName = $user->name ?? 'admin';
        $initial = strtoupper(substr($userName, 0, 1));

        $topGender = $top_gender ?? [];
    @endphp

    <div class="min-h-screen bg-gray-50 flex">
        {{-- SIDEBAR: fixed --}}
        <aside class="fixed left-0 top-0 w-[280px] h-screen bg-white border-r border-gray-200 flex flex-col">
            <div class="flex flex-col h-full">
                {{-- Header sidebar --}}
                <div class="px-6 py-5 flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-indigo-50 flex items-center justify-center overflow-hidden">
                        @if ($logoFile)
                            <img src="{{ $logoFile }}" class="h-8 w-8 object-contain" alt="Logo">
                        @else
                            <span class="text-indigo-600 font-semibold text-xs">Logo</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-wide font-semibold text-indigo-600">
                            Posyandu
                        </p>
                        <p class="text-base font-semibold text-gray-900 leading-tight">Dashboard</p>
                    </div>
                </div>

                {{-- Menu --}}
                <div class="px-6 pb-4 flex-1 overflow-y-auto">
                    <p class="text-xs font-semibold text-gray-400 uppercase mb-3">Indikator Utama</p>

                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-indigo-50 text-indigo-700 font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3.75 3.75h7.5v7.5h-7.5zM12.75 3.75h7.5v4.5h-7.5zM12.75 10.5h7.5v9.75h-7.5zM3.75 12.75h7.5v7.5h-7.5z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        {{-- Indikator Gender --}}
                        <a href="{{ route('wus-pus.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-emerald-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">WUS / PUS</span>
                        </a>

                        <a href="{{ route('pus-kb.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-sky-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">PUS KB</span>
                        </a>

                        <a href="{{ route('kb-mket.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-purple-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">KB MKET</span>
                        </a>

                        <a href="{{ route('kb-non-mket.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">KB Non-MKET</span>
                        </a>

                        <a href="{{ route('ibu-hamil.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-rose-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Ibu Hamil</span>
                        </a>

                        <a href="{{ route('ibu-hamil-tablet-besi.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Ibu Hamil (FE) I / (FE) III</span>
                        </a>

                        <a href="{{ route('ibu-hamil-meninggal.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah ibu hamil meninggal</span>
                        </a>

                        <a href="{{ route('ibu-hamil-risiko-tinggi.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Ibu Hamil dirujuk</span>
                        </a>

                        <a href="{{ route('ibu-hamil-anemia.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Ibu Hamil Anemia</span>
                        </a>

                        <a href="{{ route('ibu-hamil-kek.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Ibu Hamil KEK</span>
                        </a>

                        <a href="{{ route('kb-non-mket.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Ibu Hamil dapat imunisasi TT I / TT II</span>
                        </a>

                        <a href="{{ route('kb-non-mket.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Ibu Nifas yang mendapat Vitamin A</span>
                        </a>

                        <a href="{{ route('kb-non-mket.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Kelahiran</span>
                        </a>

                        <a href="{{ route('kb-non-mket.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Kematian Bayi / Balita</span>
                        </a>

                        <a href="{{ route('bayi-balita.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Bayi / Balita (S)</span>
                        </a>

                        <a href="{{ route('kb-non-mket.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Bayi / Balita yang memiliki KMS (K)</span>
                        </a>

                        <a href="{{ route('kb-non-mket.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Bayi / Balita yang ditimbang (D)</span>
                        </a>

                        <a href="{{ route('kb-non-mket.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Hasil penimbangan sesuai Rambu Gizi</span>
                        </a>

                        <a href="{{ route('kb-non-mket.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Balita Gizi Buruk (lama / baru)</span>
                        </a>

                        <a href="{{ route('kb-non-mket.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0 text-orange-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="text-sm">Jumlah Bayi / Balita yang memiliki KMS (K)</span>
                        </a>

                    <p class="text-xs font-semibold text-gray-400 uppercase mb-3 mt-6">Lainnya</p>

                    <nav class="space-y-1">
                        <a href="{{ route('rekap.index') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.66V18a2.25 2.25 0 002.25 2.25H18" />
                            </svg>
                            <span class="text-sm">32 Indikator</span>
                        </a>
                    </nav>
                </div>

                {{-- Footer sidebar --}}
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full flex items-center gap-3 hover:bg-gray-100 rounded-lg p-2 transition">
                            <div
                                class="h-9 w-9 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-semibold">
                                {{ $initial }}
                            </div>
                            <div class="flex-1 text-left">
                                <p class="text-sm font-semibold text-gray-900">{{ $userName }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 transition"
                                :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute bottom-full left-0 right-0 mb-2 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden z-50">
                            {{-- Settings --}}
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Pengaturan</span>
                            </a>

                            {{-- Divider --}}
                            <div class="h-px bg-gray-100"></div>

                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
        </aside>

        {{-- KONTEN KANAN --}}
        <main class="flex-1 ml-[280px] bg-gray-50 overflow-y-auto h-screen">
            <div class="p-6 space-y-6">
                {{-- Pilih Tahun Dashboard --}}
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Ringkasan peserta & indikator layanan</p>
                    </div>
                    <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">Tahun</label>
                        <select name="year" onchange="this.form.submit()"
                                class="rounded-lg border-gray-300 text-sm">
                            @foreach($available_years as $y)
                                <option value="{{ $y }}" @selected((int)$selected_year === (int)$y)>{{ $y }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                @php
                    $byAnchor = collect($topGender)->keyBy('anchor');
                    $totalPeserta = $total_peserta ?? collect($topGender)->sum('total');

                    $totalWusPus       = $byAnchor['item-1']['total'] ?? 0;
                    $totalPusKb        = $byAnchor['item-2']['total'] ?? 0;
                    $totalKbMket       = $byAnchor['item-3']['total'] ?? 0;
                    $totalKbNonMket    = $byAnchor['item-4']['total'] ?? 0;
                    $totalIbuHamil     = $byAnchor['item-5']['total'] ?? 0;
                    $totalTabletBesi   = $byAnchor['item-6']['total'] ?? ($totalTabletBesi ?? 0);
                    $totalIbuMeninggal = $byAnchor['item-7']['total'] ?? ($totalIbuMeninggal ?? 0);
                    $totalIbuRisiko    = $byAnchor['item-8']['total'] ?? 0;
                    $totalIbuAnemia    = $byAnchor['item-9']['total'] ?? ($totalIbuAnemia ?? 0);
                    $totalIbuKek       = $byAnchor['item-10']['total'] ?? ($totalIbuKek ?? 0);
                @endphp

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- SECTION 1: 5 INDIKATOR UTAMA --}}
                <section>
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Indikator Utama - Tahun
                        {{ $selected_year }}</h2>
                    {{-- Baris utama --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
                        {{-- Total Peserta --}}
                        <div
                            class="rounded-2xl border border-gray-200 bg-white shadow-sm p-5 hover:shadow-md transition">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-gray-500 font-semibold uppercase">Total Peserta</p>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-100 text-indigo-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M12 12a3 3 0 100-6 3 3 0 000 6z" />
                                        <path fill-rule="evenodd"
                                            d="M12 16c2.69 0 8 1.35 8 4v2H4v-2c0-2.65 5.31-4 8-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-3 text-3xl font-bold text-gray-900">
                                {{ number_format($totalPeserta) }}</p>
                            <p class="mt-2 text-xs text-gray-500">Jumlah total peserta</p>
                        </div>

                        {{-- WUS / PUS --}}
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 shadow-sm p-5 hover:shadow-md transition cursor-pointer"
                            onclick="window.location='{{ route('wus-pus.index') }}'">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-emerald-700 font-semibold uppercase">WUS / PUS</p>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-200 text-emerald-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M8 1a1 1 0 0 0-1 1v12H4a1 1 0 1 0 0 2h3v5a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-5h3a1 1 0 1 0 0-2h-3V2a1 1 0 0 0-1-1H8z" />
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-3 text-3xl font-bold text-emerald-900">
                                {{ number_format($totalWusPus) }}</p>
                            <p class="mt-2 text-xs text-emerald-700 font-medium">Indikator 1</p>
                        </div>

                        {{-- PUS KB --}}
                        <div class="rounded-2xl border border-sky-200 bg-sky-50 shadow-sm p-5 hover:shadow-md transition cursor-pointer"
                            onclick="window.location='{{ route('pus-kb.index') }}'">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-sky-700 font-semibold uppercase">PUS KB</p>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-sky-200 text-sky-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-3 text-3xl font-bold text-sky-900">
                                {{ number_format($totalPusKb) }}</p>
                            <p class="mt-2 text-xs text-sky-700 font-medium">Indikator 2</p>
                        </div>

                        {{-- KB MKET --}}
                        <div class="rounded-2xl border border-purple-200 bg-purple-50 shadow-sm p-5 hover:shadow-md transition cursor-pointer"
                            onclick="window.location='{{ route('kb-mket.index') }}'">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-purple-700 font-semibold uppercase">KB MKET</p>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-purple-200 text-purple-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" />
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-3 text-3xl font-bold text-purple-900">
                                {{ number_format($totalKbMket) }}</p>
                            <p class="mt-2 text-xs text-purple-700 font-medium">Indikator 3</p>
                        </div>

                        {{-- KB NON MKET --}}
                        <div class="rounded-2xl border border-orange-200 bg-orange-50 shadow-sm p-5 hover:shadow-md transition cursor-pointer"
                            onclick="window.location='{{ route('kb-non-mket.index') }}'">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-orange-700 font-semibold uppercase">KB NON MKET</p>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-orange-200 text-orange-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M3 5.25A2.25 2.25 0 0 1 5.25 3h13.5A2.25 2.25 0 0 1 21 5.25v13.5A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75V5.25Zm4.5 2.25A1.25 1.25 0 1 0 6.25 8.75 1.25 1.25 0 0 0 7.5 7.5Zm-1.25 5a1.25 1.25 0 1 0 1.25 1.25A1.25 1.25 0 0 0 6.25 12.5Zm6.25-5.625a.625.625 0 0 0-.625.625v9a.625.625 0 0 0 1.25 0v-9A.625.625 0 0 0 12.5 6.875Zm4.375 0a.625.625 0 0 0-.625.625v9a.625.625 0 0 0 1.25 0v-9a.625.625 0 0 0-.625-.625Z" />
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-3 text-3xl font-bold text-orange-900">
                                {{ number_format($totalKbNonMket) }}</p>
                            <p class="mt-2 text-xs text-orange-700 font-medium">Indikator 4</p>
                        </div>

                        {{-- Ibu Hamil --}}
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 shadow-sm p-5 hover:shadow-md transition cursor-pointer"
                            onclick="window.location='{{ route('ibu-hamil.index') }}'">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-rose-700 font-semibold uppercase">Ibu Hamil</p>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-200 text-rose-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" />
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-3 text-3xl font-bold text-rose-900">
                                {{ number_format($totalIbuHamil) }}</p>
                            <p class="mt-2 text-xs text-rose-700 font-medium">Indikator 5</p>
                        </div>
                    </div>

                    {{-- Baris tambahan: indikator khusus ibu hamil --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4 pt-2">
                        {{-- Ibu Hamil FE I / FE III --}}
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 shadow-sm p-5 hover:shadow-md transition cursor-pointer"
                            onclick="window.location='{{ route('ibu-hamil-tablet-besi.index') }}'">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-rose-700 font-semibold uppercase">Ibu Hamil FE I / FE III</p>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-200 text-rose-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" />
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-3 text-3xl font-bold text-rose-900">
                                {{ number_format($totalTabletBesi ?? 0) }}</p>
                            <p class="mt-2 text-xs text-rose-700 font-medium">Indikator 6</p>
                        </div>

                        {{-- Ibu Hamil Risiko Tinggi --}}
                        <div class="rounded-2xl border border-amber-200 bg-amber-50 shadow-sm p-5 hover:shadow-md transition cursor-pointer"
                            onclick="window.location='{{ route('ibu-hamil-risiko-tinggi.index') }}'">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-amber-700 font-semibold uppercase">Ibu Hamil Risiko Tinggi</p>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-200 text-amber-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm.75 5a.75.75 0 0 0-1.5 0v5.25a.75.75 0 0 0 1.5 0ZM12 17a1.25 1.25 0 1 0-1.25-1.25A1.25 1.25 0 0 0 12 17Z"/>
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-3 text-3xl font-bold text-amber-900">
                                {{ number_format($totalIbuRisiko ?? 0) }}</p>
                            <p class="mt-2 text-xs text-amber-700 font-medium">Indikator 8</p>
                        </div>

                        {{-- Ibu Hamil Meninggal --}}
                        <div class="rounded-2xl border border-rose-300 bg-rose-50 shadow-sm p-5 hover:shadow-md transition cursor-pointer"
                            onclick="window.location='{{ route('ibu-hamil-meninggal.index') }}'">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-rose-700 font-semibold uppercase">Ibu Hamil Meninggal</p>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-200 text-rose-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm-1 5a1 1 0 1 1 2 0v3a1 1 0 0 1-2 0zm1 10a1.25 1.25 0 1 1 1.25-1.25A1.25 1.25 0 0 1 12 17z"/>
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-3 text-3xl font-bold text-rose-900">
                                {{ number_format($totalIbuMeninggal ?? 0) }}</p>
                            <p class="mt-2 text-xs text-rose-700 font-medium">Indikator 7</p>
                        </div>

                        {{-- Ibu Hamil Anemia --}}
                        <div class="rounded-2xl border border-pink-200 bg-pink-50 shadow-sm p-5 hover:shadow-md transition cursor-pointer"
                            onclick="window.location='{{ route('ibu-hamil-anemia.index') }}'">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-pink-700 font-semibold uppercase">Ibu Hamil Anemia</p>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-pink-200 text-pink-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 5a1 1 0 1 1-1 1 1 1 0 0 1 1-1Zm0 11a1.25 1.25 0 1 1 1.25-1.25A1.25 1.25 0 0 1 12 18.25Z"/>
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-3 text-3xl font-bold text-pink-900">
                                {{ number_format($totalIbuAnemia ?? 0) }}</p>
                            <p class="mt-2 text-xs text-pink-700 font-medium">Indikator 9</p>
                        </div>

                        {{-- Ibu Hamil KEK --}}
                        <div class="rounded-2xl border border-pink-200 bg-pink-50 shadow-sm p-5 hover:shadow-md transition cursor-pointer"
                            onclick="window.location='{{ route('ibu-hamil-kek.index') }}'">
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-pink-700 font-semibold uppercase">Ibu Hamil KEK</p>
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-pink-200 text-pink-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm0 5a1 1 0 1 1-1 1 1 1 0 0 1 1-1Zm0 11a1.25 1.25 0 1 1 1.25-1.25A1.25 1.25 0 0 1 12 18.25Z"/>
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-3 text-3xl font-bold text-pink-900">
                                {{ number_format($totalIbuKek ?? 0) }}</p>
                            <p class="mt-2 text-xs text-pink-700 font-medium">Indikator 10</p>
                        </div>
                    </div>
                </section>

                {{-- SECTION 2: STATISTIK PER KATEGORI --}}
                @if (!empty($balita) || !empty($imunisasi) || !empty($ibu) || !empty($konsultasi))
                    <section>
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Statistik Layanan per Bulan</h2>
                        <div class="grid grid-cols-2 gap-4">
                            {{-- Chart Balita --}}
                            @if (!empty($balita))
                                <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                                    <h3 class="text-sm font-bold text-gray-900 mb-4">
                                        {{ $category_labels['balita'] ?? 'Balita' }}</h3>
                                    <div class="h-64" id="chartBalita"></div>
                                    <p class="mt-3 text-xs text-gray-500">Total: <span
                                            class="font-bold text-gray-900">{{ number_format($total_balita) }}</span>
                                        peserta</p>
                                </div>
                            @endif

                            {{-- Chart Imunisasi --}}
                            @if (!empty($imunisasi))
                                <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                                    <h3 class="text-sm font-bold text-gray-900 mb-4">
                                        {{ $category_labels['imunisasi'] ?? 'Imunisasi' }}</h3>
                                    <div class="h-64" id="chartImunisasi"></div>
                                    <p class="mt-3 text-xs text-gray-500">Total: <span
                                            class="font-bold text-gray-900">{{ number_format($total_imunisasi) }}</span>
                                        peserta</p>
                                </div>
                            @endif

                            {{-- Chart Ibu --}}
                            @if (!empty($ibu))
                                <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                                    <h3 class="text-sm font-bold text-gray-900 mb-4">
                                        {{ $category_labels['ibu'] ?? 'Ibu' }}</h3>
                                    <div class="h-64" id="chartIbu"></div>
                                    <p class="mt-3 text-xs text-gray-500">Total: <span
                                            class="font-bold text-gray-900">{{ number_format($total_ibu) }}</span>
                                        peserta</p>
                                </div>
                            @endif

                            {{-- Chart Konsultasi --}}
                            @if (!empty($konsultasi))
                                <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                                    <h3 class="text-sm font-bold text-gray-900 mb-4">
                                        {{ $category_labels['konsultasi'] ?? 'Konsultasi' }}</h3>
                                    <div class="h-64" id="chartKonsultasi"></div>
                                    <p class="mt-3 text-xs text-gray-500">Total: <span
                                            class="font-bold text-gray-900">{{ number_format($total_konsultasi) }}</span>
                                        peserta</p>
                                </div>
                            @endif
                        </div>
                    </section>
                @endif

                {{-- SECTION 3: QUICK INPUT FORM --}}
                <section>
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Input Data Cepat</h2>
                    <form action="{{ route('dashboard.store') }}" method="POST"
                        class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                        @csrf
                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                                <select name="category" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="balita">Penimbangan Balita</option>
                                    <option value="imunisasi">Imunisasi Anak</option>
                                    <option value="ibu">Pemeriksaan Ibu Hamil</option>
                                    <option value="konsultasi">Konsultasi Kesehatan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                                <select name="month" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Pilih Bulan --</option>
                                    @foreach ($month_options as $no => $name)
                                        <option value="{{ $no }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                                <input type="number" name="year" value="{{ $selected_year }}" min="2000"
                                    max="2100" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                                <input type="number" name="value" min="0" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit"
                                class="rounded-lg bg-indigo-600 text-white px-6 py-2 text-sm font-semibold hover:bg-indigo-700 transition">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </section>

                {{-- SECTION 4: RINGKASAN PROGRESS --}}
                <section>
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Progress Input</h2>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-5">
                            <p class="text-xs text-gray-500 font-semibold uppercase">Total Input</p>
                            <p class="mt-3 text-3xl font-bold text-gray-900">{{ number_format($sum_all) }}
                            </p>
                            <p class="mt-2 text-xs text-gray-500">Data yang sudah diinput</p>
                        </div>

                        <div class="rounded-2xl border border-yellow-200 bg-yellow-50 shadow-sm p-5">
                            <p class="text-xs text-yellow-700 font-semibold uppercase">Perlu Input</p>
                            <p class="mt-3 text-3xl font-bold text-yellow-900">
                                {{ number_format($need_input) }}</p>
                            <p class="mt-2 text-xs text-yellow-700">Bulan yang masih kosong</p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-5">
                            <p class="text-xs text-gray-500 font-semibold uppercase">Kategori Lengkap</p>
                            <p class="mt-3 text-3xl font-bold text-gray-900">{{ $filled_categories }}/4
                            </p>
                            <p class="mt-2 text-xs text-gray-500">Kategori dengan data</p>
                        </div>

                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 shadow-sm p-5">
                            <p class="text-xs text-emerald-700 font-semibold uppercase">Coverage</p>
                            <p class="mt-3 text-3xl font-bold text-emerald-900">
                                {{ round($input_coverage) }}%</p>
                            <p class="mt-2 text-xs text-emerald-700">Kelengkapan data tahun ini</p>
                        </div>
                    </div>
                </section>
            </div>
        </main>

    </div>

    {{-- Chart Libraries & Scripts --}}
    <script>
        // Helper function untuk render chart
        function renderChart(elementId, label, data, color) {
            const ctx = document.getElementById(elementId);
            if (!ctx) return;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: label,
                        data: data,
                        borderColor: color,
                        backgroundColor: color + '20',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointBackgroundColor: color,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e5e7eb'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // Render charts
        @if (!empty($balita))
            renderChart('chartBalita', 'Penimbangan Balita', @json($balita), '#10b981');
        @endif

        @if (!empty($imunisasi))
            renderChart('chartImunisasi', 'Imunisasi Anak', @json($imunisasi), '#0ea5e9');
        @endif

        @if (!empty($ibu))
            renderChart('chartIbu', 'Pemeriksaan Ibu Hamil', @json($ibu), '#f97316');
        @endif

        @if (!empty($konsultasi))
            renderChart('chartKonsultasi', 'Konsultasi Kesehatan', @json($konsultasi), '#8b5cf6');
        @endif
    </script>
</body>

</html>
