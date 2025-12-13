@php use Illuminate\Support\Str; @endphp
@php
    $rekapMenu = $rekap_list ?? [
        ['no' => 1, 'label' => 'Jumlah WUS / PUS'],
        ['no' => 2, 'label' => 'Jumlah PUS ikut KB'],
        ['no' => 3, 'label' => 'Peserta KB MKET'],
        ['no' => 4, 'label' => 'Peserta KB non MKET'],
        ['no' => 5, 'label' => 'Jumlah Ibu Hamil'],
        ['no' => 6, 'label' => 'Ibu Hamil dapat Tablet Besi'],
        ['no' => 7, 'label' => 'Ibu Hamil Risiko Tinggi'],
        ['no' => 8, 'label' => 'Ibu Hamil Risiko Tinggi Dirujuk'],
        ['no' => 9, 'label' => 'Ibu Hamil Anemia'],
        ['no' => 10, 'label' => 'Ibu Hamil KEK'],
        ['no' => 11, 'label' => 'Ibu Hamil dapat TT I / TT II'],
        ['no' => 12, 'label' => 'Ibu Hamil Meninggal'],
        ['no' => 13, 'label' => 'Ibu Nifas Vit A'],
        ['no' => 14, 'label' => 'Jumlah Kelahiran'],
        ['no' => 15, 'label' => 'Kematian Bayi / Balita'],
        ['no' => 16, 'label' => 'Jumlah Bayi / Balita (S)'],
        ['no' => 17, 'label' => 'Bayi / Balita dengan KMS (K)'],
        ['no' => 18, 'label' => 'Bayi / Balita Ditimbang (D)'],
        ['no' => 19, 'label' => 'Penimbangan Sesuai Rambu Gizi'],
        ['no' => 20, 'label' => 'Balita Gizi Buruk (Lama/Baru)'],
        ['no' => 21, 'label' => 'Balita Gizi Buruk Dapat Perawatan'],
        ['no' => 22, 'label' => 'Balita Bawah Garis Merah (BGM)'],
        ['no' => 23, 'label' => 'Balita Tidak Naik BB 2x'],
        ['no' => 24, 'label' => 'Bayi 6-24 bln Gakin MP-ASI'],
        ['no' => 25, 'label' => 'Bayi 6-24 bln Vit A (6-11)'],
        ['no' => 26, 'label' => 'Bayi/Anak Vit A (12-59)'],
        ['no' => 27, 'label' => 'Balita PMT Pemulihan'],
        ['no' => 28, 'label' => 'Bayi Imunisasi BCG'],
        ['no' => 29, 'label' => 'Bayi Imunisasi Campak'],
        ['no' => 30, 'label' => 'Bayi Imunisasi Polio'],
        ['no' => 31, 'label' => 'ASI Eksklusif'],
        ['no' => 32, 'label' => 'Bayi BBLR'],
    ];

    $menuSections = [
        [
            'title' => 'Dashboard',
            'items' => [
                ['label' => 'Dashboard Utama', 'href' => route('dashboard'), 'icon' => 'M3 5h18M3 12h18M3 19h18'],
            ],
        ],
        [
            'title' => 'Keluarga Berencana',
            'items' => array_slice($rekapMenu, 0, 4),
        ],
        [
            'title' => 'Ibu Hamil & Nifas',
            'items' => array_slice($rekapMenu, 4, 10),
        ],
        [
            'title' => 'Bayi & Balita',
            'items' => array_slice($rekapMenu, 14, 9),
        ],
        [
            'title' => 'Gizi & Imunisasi',
            'items' => array_slice($rekapMenu, 23),
        ],
    ];
@endphp

<aside class="hidden md:flex w-72 bg-white border-r border-slate-200 flex-col">
    <div class="px-6 py-5 flex items-center gap-3 border-b border-slate-200">
        <div class="h-10 w-10 rounded-lg bg-sky-600 text-white flex items-center justify-center font-bold">P</div>
        <div>
            <div class="text-lg font-bold text-slate-800">Posyandu Pintar</div>
            <div class="text-xs text-slate-500">Panel Administrasi</div>
        </div>
    </div>
    <div class="flex-1 overflow-y-auto py-4">
        @foreach ($menuSections as $section)
            <div class="px-4 mb-3">
                <div class="text-[11px] font-semibold uppercase tracking-[0.08em] text-slate-400 mb-2">{{ $section['title'] }}</div>
                <div class="space-y-1">
                    @foreach ($section['items'] as $item)
                        @php
                            $href = $item['href'] ?? (route('dashboard') . '#item-' . $item['no']);
                            $label = $item['label'];
                            $active = str_contains(url()->full(), trim($href, '#')) ? 'bg-sky-50 text-sky-700 border-sky-200' : 'text-slate-600 hover:bg-slate-50';
                        @endphp
                        <a href="{{ $href }}" class="flex items-center gap-3 px-3 py-2 rounded-lg border border-transparent {{ $active }}">
                            @if(isset($item['icon']))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                </svg>
                            @else
                                <span class="text-[11px] font-semibold text-slate-400 w-6">{{ $item['no'] ?? '-' }}</span>
                            @endif
                            <span class="text-sm">{{ $label }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <div class="p-4 border-t border-slate-200">
        @auth
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center font-semibold">
                    {{ strtoupper(Str::substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
        @else
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('login') }}" class="text-sky-600 font-semibold">Login</a>
                <span class="text-slate-400">/</span>
                <a href="{{ route('register') }}" class="text-slate-600 hover:text-sky-600">Register</a>
            </div>
        @endauth
    </div>
</aside>
