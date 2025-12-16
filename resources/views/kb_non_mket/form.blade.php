@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-4">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900">{{ $title }}</h1>
            <p class="text-sm text-gray-500">Isi data tahun, bulan, dan jumlah peserta KB non MKET</p>
        </div>

        <a href="{{ route('kb-non-mket.index', ['tahun' => $return_year ?? now()->year]) }}"
           class="px-3 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="p-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-100">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $formAction }}" class="bg-white rounded-xl shadow-sm border p-4 space-y-4">
        <input type="hidden" name="return_year" value="{{ $return_year ?? old('return_year', now()->year) }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="text-sm text-gray-600">Tahun</label>
                <input type="number" name="tahun" min="2000" max="2100" required
                       value="{{ old('tahun', $item->year ?? now()->year) }}"
                       class="mt-1 w-full rounded-lg border-gray-300">
            </div>

            <div>
                <label class="text-sm text-gray-600">Bulan</label>
                @php
                    $bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                    $selected = old('bulan', $item->bulan ?? '');
                @endphp
                <select name="bulan" required class="mt-1 w-full rounded-lg border-gray-300">
                    <option value="">-- pilih --</option>
                    @foreach($bulanList as $b)
                        <option value="{{ $b }}" @selected($selected === $b)>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="text-sm text-gray-600">Jumlah</label>
                <input type="number" name="jumlah" min="0" required
                       value="{{ old('jumlah', $item->jumlah ?? 0) }}"
                       class="mt-1 w-full rounded-lg border-gray-300">
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800">
                {{ $isEdit ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>

</div>
@endsection
