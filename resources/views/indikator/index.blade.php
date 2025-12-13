{{-- resources/views/indikator/index.blade.php --}}
@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8 space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                    {{ $title }}
                </h1>
                <p class="text-sm text-gray-500">
                    Kelola data per tahun, dengan nilai Laki-laki dan Perempuan.
                </p>
            </div>

            <a href="{{ route($routePrefix . '.create') }}"
               class="inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold text-indigo-700 bg-indigo-100 border border-indigo-400 hover:bg-indigo-200 hover:text-indigo-900 transition">
                + Tambah Data
            </a>

        </div>

        {{-- ALERT SUCCESS --}}
        @if (session('success'))
            <div class="rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800 flex items-start justify-between">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    Tutup
                </button>
            </div>
        @endif

        {{-- TABEL DATA --}}
        <div class="bg-gray-50 rounded-xl shadow-md border border-gray-200">
            <div class="px-4 py-3 bg-gray-100 border-b border-gray-300 flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-800">Daftar Data</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">Tahun</th>
                            <th class="px-4 py-2 text-right">Laki-laki</th>
                            <th class="px-4 py-2 text-right">Perempuan</th>
                            <th class="px-4 py-2 text-right">Total</th>
                            <th class="px-4 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($items as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-xs text-gray-500">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $row->year }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-right">
                                    {{ number_format($row->male) }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    {{ number_format($row->female) }}
                                </td>
                                <td class="px-4 py-2 text-right font-semibold text-gray-900">
                                    {{ number_format($row->male + $row->female) }}
                                </td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <a href="{{ route($routePrefix . '.edit', $row->id) }}"
                                       class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-sky-50 text-sky-700 hover:bg-sky-100">
                                        Edit
                                    </a>

                                    <form action="{{ route($routePrefix . '.destroy', $row->id) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Yakin ingin menghapus data tahun {{ $row->year }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-red-50 text-red-700 hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-400">
                                    Belum ada data. Klik tombol <strong>Tambah Data</strong> di kanan atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection
