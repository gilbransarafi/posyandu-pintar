@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-4">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900">{{ $title }}</h1>
            <p class="text-sm text-gray-500">Data per bulan untuk tahun {{ $year }}</p>
        </div>

        <div class="flex items-center gap-2">
            <form method="GET" action="{{ route('ibu-hamil-tablet-besi.index') }}" class="flex items-center gap-2">
                <label class="text-sm text-gray-600">Tahun</label>
                <select name="year" class="rounded-lg border-gray-300 text-sm" onchange="this.form.submit()">
                    @foreach($available_years as $y)
                        <option value="{{ $y }}" @selected((int)$year === (int)$y)>{{ $y }}</option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('ibu-hamil-tablet-besi.create', ['year' => $year]) }}"
               class="px-3 py-2 rounded-lg bg-rose-600 text-white text-sm hover:bg-rose-700">
                + Tambah
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="p-3 rounded-lg bg-green-50 text-green-700 text-sm border border-green-100">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-4 py-3">Bulan</th>
                    <th class="text-right px-4 py-3">FE I</th>
                    <th class="text-right px-4 py-3">FE III</th>
                    <th class="text-right px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($items as $row)
                    <tr class="hover:bg-gray-50/60">
                        <td class="px-4 py-3">{{ $row->bulan }}</td>
                        <td class="px-4 py-3 text-right font-semibold">{{ number_format($row->fe1) }}</td>
                        <td class="px-4 py-3 text-right font-semibold">{{ number_format($row->fe3) }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('ibu-hamil-tablet-besi.edit', $row->id) }}"
                                   class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-700 hover:bg-sky-100">
                                    Edit
                                </a>

                                <form action="{{ route('ibu-hamil-tablet-besi.destroy', $row->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1.5 rounded-lg bg-red-50 text-red-700 hover:bg-red-100">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            Belum ada data untuk tahun {{ $year }}.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
     <div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                Kembali ke Dashboard
            </a>
    </div>

</div>
@endsection
