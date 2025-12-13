{{-- resources/views/indikator/form.blade.php --}}
@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8 space-y-6">
        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                    {{ $title }}
                </h1>
                <p class="text-sm text-gray-500">
                    Isi tahun dan jumlah Laki-laki / Perempuan.
                </p>
            </div>

            <a href="{{ route($routePrefix . '.index') }}"
               class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200">
                Kembali
            </a>
        </div>

        {{-- FORM --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5">
            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    <p class="font-semibold">Terjadi kesalahan:</p>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $isEdit = $isEdit ?? (isset($item) && $item);
                $formAction = $formAction
                    ?? ($isEdit
                        ? route($routePrefix . '.update', $item->id ?? 0)
                        : route($routePrefix . '.store'));
            @endphp

            <form method="POST" action="{{ $formAction }}" class="space-y-4">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                {{-- Tahun --}}
                <div>
                    <label for="year" class="block text-xs font-medium text-gray-700 mb-1">
                        Tahun
                    </label>
                    <input type="number" name="year" id="year"
                           class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('year') border-red-500 @enderror"
                           value="{{ old('year', $item->year ?? now()->year) }}"
                           min="2000" max="2100" required>
                    @error('year')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Laki-laki --}}
                <div>
                    <label for="male" class="block text-xs font-medium text-gray-700 mb-1">
                        Jumlah Laki-laki
                    </label>
                    <input type="number" name="male" id="male" min="0"
                           class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('male') border-red-500 @enderror"
                           value="{{ old('male', $item->male ?? 0) }}"
                           required>
                    @error('male')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Perempuan --}}
                <div>
                    <label for="female" class="block text-xs font-medium text-gray-700 mb-1">
                        Jumlah Perempuan
                    </label>
                    <input type="number" name="female" id="female" min="0"
                           class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('female') border-red-500 @enderror"
                           value="{{ old('female', $item->female ?? 0) }}"
                           required>
                    @error('female')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <a href="{{ route($routePrefix . '.index') }}"
                       class="inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
