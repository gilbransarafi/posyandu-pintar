{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Posyandu Pintar')
@section('no_app_sidebar', '1')

@section('content')
@php
    $logoFile = file_exists(public_path('images/logo-posyandu.png'))
        ? asset('images/logo-posyandu.png')
        : (file_exists(public_path('images/Logo Posyandu.png')) ? asset('images/Logo Posyandu.png') : null);

    $user       = auth()->user();
    $userName   = $user->name ?? 'admin';
    $initial    = strtoupper(substr($userName, 0, 1));

    $topGender      = $top_gender ?? [];
    $totalPeserta   = $total_peserta ?? collect($topGender)->sum('total');

    $totalWusPus    = $topGender[0]['total'] ?? 0;
    $totalPusKb     = $topGender[1]['total'] ?? 0;
    $totalIbuHamil  = $topGender[4]['total'] ?? 0;
@endphp

<div class="min-h-screen bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">

        {{-- LAYOUT APP: sidebar kiri + konten kanan (SELALU 2 kolom) --}}
        <div class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="grid grid-cols-[280px_1fr]">

                {{-- SIDEBAR: sticky + full height --}}
                <aside class="bg-white border-r border-gray-200">
                    <div class="sticky top-0 h-[calc(100vh-48px)] flex flex-col">
                        {{-- Header sidebar --}}
                        <div class="px-6 py-5 flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl bg-indigo-50 flex items-center justify-center overflow-hidden">
                                @if($logoFile)
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
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-gray-100 text-gray-900 font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M3.75 3.75h7.5v7.5h-7.5zM12.75 3.75h7.5v4.5h-7.5zM12.75 10.5h7.5v9.75h-7.5zM3.75 12.75h7.5v7.5h-7.5z"/>
                                    </svg>
                                    <span>Dashboard</span>
                                </a>

                                @foreach($topGender as $stat)
                                    <a href="#{{ $stat['anchor'] ?? 'indikator-'.$stat['no'] }}"
                                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M4.5 6.75h15M4.5 12h15M4.5 17.25h15"/>
                                        </svg>
                                        <span class="text-sm">{{ $stat['label'] }}</span>
                                    </a>
                                @endforeach
                            </nav>
                        </div>

                        {{-- Footer sidebar --}}
                        <div class="px-6 py-4 border-t border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center text-sm font-semibold">
                                    {{ $initial }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">{{ $userName }}</p>
                                    <p class="text-xs text-gray-500">admin</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m6 9 6 6 6-6"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </aside>

                {{-- KONTEN KANAN --}}
                <main class="min-w-0 bg-gray-50">
                    {{-- Topbar kanan --}}
                    <div class="h-16 px-6 flex items-center justify-between bg-white border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gray-100 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Dashboard</p>
                                <p class="text-xs text-gray-500">Ringkasan peserta & indikator layanan</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            @if(!empty($available_years))
                                <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
                                    <span class="text-xs text-gray-600 font-semibold">Tahun</span>
                                    <select name="year"
                                            class="h-9 rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            onchange="this.form.submit()">
                                        @foreach($available_years as $year)
                                            <option value="{{ $year }}" @selected($year == $selected_year)>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            @endif

                            <button type="button"
                                    class="relative h-9 w-9 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 flex items-center justify-center">
                                <span class="absolute -top-1 -right-1 inline-flex h-5 w-5 items-center justify-center rounded-full bg-rose-500 text-[11px] font-semibold text-white">3</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 10a6 6 0 1 0-12 0v4l-1.2 2.4a.5.5 0 0 0 .45.73h13.5a.5.5 0 0 0 .45-.73L18 14v-4Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 18a2 2 0 0 0 4 0" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Isi konten --}}
                    <div class="p-6 space-y-5">
                        @if (session('success'))
                            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Cards atas (lebih mirip contoh: tetap grid) --}}
                        <section class="grid grid-cols-4 gap-4">
                            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-5">
                                <p class="text-sm text-gray-500 font-medium">Total Peserta</p>
                                <p class="mt-3 text-3xl font-bold text-gray-900">{{ number_format($totalPeserta) }}</p>
                                <p class="mt-1 text-xs text-gray-500">Tahun {{ $selected_year }}</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-5">
                                <p class="text-sm text-gray-500 font-medium">Jumlah WUS / PUS</p>
                                <p class="mt-3 text-3xl font-bold text-gray-900">{{ number_format($totalWusPus) }}</p>
                                <p class="mt-1 text-xs text-emerald-600">Indikator 1</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-5">
                                <p class="text-sm text-gray-500 font-medium">PUS ikut KB</p>
                                <p class="mt-3 text-3xl font-bold text-gray-900">{{ number_format($totalPusKb) }}</p>
                                <p class="mt-1 text-xs text-sky-600">Indikator 2</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-5">
                                <p class="text-sm text-gray-500 font-medium">Jumlah Ibu Hamil</p>
                                <p class="mt-3 text-3xl font-bold text-gray-900">{{ number_format($totalIbuHamil) }}</p>
                                <p class="mt-1 text-xs text-rose-600">Indikator 5</p>
                            </div>
                        </section>

                        {{-- sisanya biarkan seperti punya kamu (3 card + tabel + dll) --}}
                        {{-- kamu bisa tempel lagi bagian bawah dari file kamu, mulai dari "3 CARD TENGAH" sampai bawah --}}
                    </div>
                </main>

            </div>
        </div>

    </div>
</div>
@endsection
