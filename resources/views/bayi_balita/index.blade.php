@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-4">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900">{{ $title }}</h1>
            <p class="text-sm text-gray-500">Data per kategori usia (L/P)</p>
        </div>
        <a href="{{ route('bayi-balita.create') }}"
           class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">
            + Tambah
        </a>
    </div>

    @if(session('success'))
        <div class="p-3 rounded bg-green-50 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="text-left">
                    <th class="px-4 py-3 font-semibold text-gray-700">Tahun</th>
                    <th class="px-4 py-3 font-semibold text-gray-700">Kategori Usia</th>
                    <th class="px-4 py-3 font-semibold text-gray-700">L</th>
                    <th class="px-4 py-3 font-semibold text-gray-700">P</th>
                    <th class="px-4 py-3 font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($items as $it)
                    <tr>
                        <td class="px-4 py-3">{{ $it->tahun }}</td>
                        <td class="px-4 py-3">{{ $it->usia_kategori }}</td>
                        <td class="px-4 py-3">{{ $it->laki_laki }}</td>
                        <td class="px-4 py-3">{{ $it->perempuan }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <a class="px-3 py-1 rounded bg-yellow-500 text-white hover:bg-yellow-600"
                               href="{{ route('bayi-balita.edit', $it->id) }}">Edit</a>

                            <form action="{{ route('bayi-balita.destroy', $it->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            Belum ada data.
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
