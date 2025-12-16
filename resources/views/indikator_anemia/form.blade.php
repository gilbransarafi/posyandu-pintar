@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-4">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900">{{ $title }}</h1>
            <p class="text-sm text-gray-500">Isi data tahun, bulan, dan jumlah</p>
        </div>

        <a href="{{ route('ibu-hamil-anemia.index', ['tahun' => $return_year ?? now()->year]) }}"
           class="px-3 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="p-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-100">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $action }}" method="POST" class="bg-white rounded-xl shadow-sm border p-4 space-y-4">
        <input type="hidden" name="return_year" value="{{ $return_year ?? old('return_year', now()->year) }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="block text-sm text-gray-700 mb-1">Tahun</label>
                <input type="number" name="tahun"
                       value="{{ old('tahun', $item->tahun ?? now()->year) }}"
                       class="w-full rounded-md border-gray-300"
                       min="2000" max="2100" required>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Bulan</label>
                @php
                    $bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                    $selected = (int) old('bulan', $item->bulan ?? 0);
                @endphp
                <select name="bulan" class="w-full rounded-md border-gray-300" required>
                    <option value="">-- pilih --</option>
                    @foreach($bulanList as $idx => $b)
                        <option value="{{ $idx + 1 }}" @selected($selected === ($idx + 1))>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm text-gray-700 mb-1">Jumlah</label>
                <input type="number" name="jumlah"
                       value="{{ old('jumlah', $item->jumlah ?? 0) }}"
                       class="w-full rounded-md border-gray-300"
                       min="0" required>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <button class="px-4 py-2 rounded-md bg-gray-900 text-white text-sm hover:bg-gray-800">
                Simpan
            </button>
        </div>
    </form>

</div>
@endsection
