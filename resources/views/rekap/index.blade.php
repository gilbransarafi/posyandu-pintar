@extends('layouts.app')

@section('title', 'Input Rekap Posyandu')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8 space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                    Input Rekap Posyandu
                </h1>
                <p class="text-sm text-gray-500">
                    Form digital dari lembar rekap 1–32 seperti di kertas.
                </p>
            </div>

            <form method="GET" action="{{ route('rekap.index') }}" class="flex items-center gap-2">
                <label for="year" class="text-sm text-gray-600">Tahun</label>
                <input id="year" type="number" name="year"
                       value="{{ $selected_year }}"
                       class="w-24 rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <button type="submit"
                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                    Ganti
                </button>
            </form>

            <div class="flex items-center gap-2">
                <a href="{{ route('rekap.pdf', ['year' => $selected_year]) }}"
                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700"
                   target="_blank" rel="noopener">
                    Download PDF
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800 space-y-1">
                <p class="font-semibold">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('rekap.store') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="year" value="{{ $selected_year }}">

            <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-100">
                <table class="min-w-full text-xs sm:text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200 text-[11px] uppercase text-gray-500">
                        <tr>
                            <th class="px-3 py-2 text-left font-medium w-10">No</th>
                            <th class="px-3 py-2 text-left font-medium">Uraian</th>
                            <th class="px-3 py-2 text-right font-medium w-24">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($rekap_list as $row)
                            @php
                                $code = $row['anchor'];
                            @endphp
                            <tr class="hover:bg-gray-50/70">
                                <td class="px-3 py-2 align-top text-gray-700">
                                    {{ $row['no'] }}
                                </td>
                                <td class="px-3 py-2 align-top text-gray-800">
                                    {{ $row['label'] }}
                                </td>
                                <td class="px-3 py-2 align-top">
                                    <input type="number" min="0"
                                           name="rekap[{{ $code }}][value]"
                                           value="{{ old("rekap.$code.value", $row['value'] ?? 0) }}"
                                           class="w-24 text-right rounded-md border-gray-300 text-xs sm:text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Rekap
                </button>
            </div>
        </form>

        <div>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:underline">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection
