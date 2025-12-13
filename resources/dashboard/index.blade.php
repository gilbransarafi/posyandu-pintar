@extends('layouts.app')

@section('title', 'Dashboard Posyandu Pintar')

@section('content')

{{-- CARD ATAS --}}
<section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
    <div class="rounded-2xl bg-white border p-6">
        <p class="text-sm text-gray-500">Total Peserta</p>
        <p class="mt-3 text-3xl font-bold">32</p>
        <p class="text-xs text-gray-400 mt-1">Tahun {{ $selected_year }}</p>
    </div>

    <div class="rounded-2xl bg-white border p-6">
        <p class="text-sm text-gray-500">Jumlah WUS / PUS</p>
        <p class="mt-3 text-3xl font-bold">10</p>
        <p class="text-xs text-emerald-600">Indikator 1</p>
    </div>

    <div class="rounded-2xl bg-white border p-6">
        <p class="text-sm text-gray-500">PUS Ikut KB</p>
        <p class="mt-3 text-3xl font-bold">9</p>
        <p class="text-xs text-sky-600">Indikator 2</p>
    </div>

    <div class="rounded-2xl bg-white border p-6">
        <p class="text-sm text-gray-500">Jumlah Ibu Hamil</p>
        <p class="mt-3 text-3xl font-bold">0</p>
        <p class="text-xs text-rose-600">Indikator 5</p>
    </div>
</section>


@endsection
