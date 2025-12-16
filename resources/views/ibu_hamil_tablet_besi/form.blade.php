@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-4">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900">{{ $title }}</h1>
            <p class="text-sm text-gray-500">Isi data FE I & FE III</p>
        </div>
        <a href="{{ route('ibu-hamil-tablet-besi.index', ['year' => $year]) }}"
           class="px-3 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="p-3 rounded-lg bg-red-50 text-red-700 text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $formAction }}" class="bg-white rounded-xl shadow-sm border p-4 space-y-4">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="text-sm text-gray-600">Tahun</label>
                <input type="number" name="tahun"
                       value="{{ old('tahun', $item->tahun ?? $year) }}"
                       class="mt-1 w-full rounded-lg border-gray-300"
                       min="2000" max="2100" required>
            </div>

            <div>
                <label class="text-sm text-gray-600">Bulan</label>
                <select name="bulan" class="mt-1 w-full rounded-lg border-gray-300" required>
                    @php
                        $bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        $selected = old('bulan', $item->bulan ?? '');
                    @endphp
                    <option value="">-- pilih --</option>
                    @foreach($bulanList as $b)
                        <option value="{{ $b }}" @selected($selected === $b)>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">FE I</label>
                <input type="number" name="fe1"
                       value="{{ old('fe1', $item->fe1 ?? 0) }}"
                       class="mt-1 w-full rounded-lg border-gray-300"
                       min="0" required>
            </div>

            <div>
                <label class="text-sm text-gray-600">FE III</label>
                <input type="number" name="fe3"
                       value="{{ old('fe3', $item->fe3 ?? 0) }}"
                       class="mt-1 w-full rounded-lg border-gray-300"
                       min="0" required>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <button class="px-4 py-2 rounded-lg bg-rose-600 text-white hover:bg-rose-700">
                {{ $isEdit ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>

</div>
@endsection
