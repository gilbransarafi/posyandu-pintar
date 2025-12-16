@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 space-y-4">

    <div>
        <h1 class="text-xl font-bold text-gray-900">{{ $title }}</h1>
        <p class="text-sm text-gray-500">Isi data sesuai kategori usia dan jenis kelamin</p>
    </div>

    @if($errors->any())
        <div class="p-3 rounded bg-red-50 text-red-700 text-sm">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $formAction }}" method="POST" class="bg-white rounded-lg shadow p-5 space-y-4">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm text-gray-600">Tahun</label>
                <input type="number" name="tahun"
                       value="{{ old('tahun', $item->tahun ?? date('Y')) }}"
                       class="mt-1 w-full rounded-md border-gray-300 text-sm"
                       required>
            </div>

            <div>
                <label class="text-sm text-gray-600">Kategori Usia</label>
                <select name="usia_kategori" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
                    <option value="">-- pilih --</option>
                    @foreach($usiaOptions as $opt)
                        <option value="{{ $opt }}"
                            @selected(old('usia_kategori', $item->usia_kategori ?? '') === $opt)>
                            {{ $opt }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">L (Laki-laki)</label>
                <input type="number" min="0" name="laki_laki"
                       value="{{ old('laki_laki', $item->laki_laki ?? 0) }}"
                       class="mt-1 w-full rounded-md border-gray-300 text-sm">
            </div>

            <div>
                <label class="text-sm text-gray-600">P (Perempuan)</label>
                <input type="number" min="0" name="perempuan"
                       value="{{ old('perempuan', $item->perempuan ?? 0) }}"
                       class="mt-1 w-full rounded-md border-gray-300 text-sm">
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">
                {{ $isEdit ? 'Update' : 'Simpan' }}
            </button>
            <a href="{{ route('bayi-balita.index') }}"
               class="px-4 py-2 rounded-md bg-gray-100 text-gray-700 text-sm hover:bg-gray-200">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection
