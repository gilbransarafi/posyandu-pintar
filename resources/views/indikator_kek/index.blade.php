@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-4">

  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h1 class="text-xl font-bold text-gray-900">{{ $title }}</h1>
      <p class="text-sm text-gray-500">Kelola data per bulan</p>
    </div>

    <div class="flex items-center gap-2">
      <form method="GET" action="{{ route('ibu-hamil-kek.index') }}" class="flex items-center gap-2">
        <label class="text-sm text-gray-600">Tahun</label>
        <select name="tahun" class="rounded-lg border-gray-300 text-sm" onchange="this.form.submit()">
          @foreach($available_years as $y)
            <option value="{{ $y }}" @selected((int)$selected_year === (int)$y)>{{ $y }}</option>
          @endforeach
        </select>
      </form>

      <a href="{{ route('ibu-hamil-kek.create', ['tahun' => $selected_year]) }}" class="px-3 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700">
        + Tambah Data
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="p-3 rounded-lg bg-green-50 text-green-700 text-sm border border-green-100">{{ session('success') }}</div>
  @endif

  <div class="bg-white rounded-xl shadow-sm border overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50 text-gray-700">
        <tr>
          <th class="px-4 py-3 text-left w-16">No</th>
          <th class="px-4 py-3 text-left">Tahun</th>
          <th class="px-4 py-3 text-left">Bulan</th>
          <th class="px-4 py-3 text-right">Jumlah</th>
          <th class="px-4 py-3 text-right w-48">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse($items as $i => $row)
          @php
            $bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            $bulanLabel = $bulanList[(int)$row->bulan - 1] ?? $row->bulan;
          @endphp
          <tr class="hover:bg-gray-50/60">
            <td class="px-4 py-3">{{ $i+1 }}</td>
            <td class="px-4 py-3">{{ $row->tahun }}</td>
            <td class="px-4 py-3">{{ $bulanLabel }}</td>
            <td class="px-4 py-3 text-right font-semibold">{{ number_format($row->jumlah) }}</td>
            <td class="px-4 py-3">
              <div class="flex justify-end gap-2">
                <a class="px-3 py-1.5 rounded bg-sky-50 text-sky-700 hover:bg-sky-100"
                   href="{{ route('ibu-hamil-kek.edit', ['ibu_hamil_kek' => $row->id, 'tahun' => $selected_year]) }}">
                  Edit
                </a>
                <form action="{{ route('ibu-hamil-kek.destroy', ['ibu_hamil_kek' => $row->id, 'tahun' => $selected_year]) }}" method="POST"
                      onsubmit="return confirm('Hapus data ini?')">
                  @csrf
                  @method('DELETE')
                  <button class="px-3 py-1.5 rounded bg-red-50 text-red-700 hover:bg-red-100">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-4 py-6 text-center text-gray-500">Data belum ada untuk tahun {{ $selected_year }}.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

   <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:underline">
        Kembali ke Dashboard
    </a>
</div>
@endsection
