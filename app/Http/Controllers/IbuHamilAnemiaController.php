<?php

namespace App\Http\Controllers;

use App\Models\IbuHamilAnemia;
use Illuminate\Http\Request;

class IbuHamilAnemiaController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('tahun', now()->year);

        $availableYears = IbuHamilAnemia::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (! in_array($year, $availableYears, true)) {
            $availableYears[] = $year;
            rsort($availableYears);
        }

        $items = IbuHamilAnemia::where('tahun', $year)
            ->orderBy('bulan', 'asc')
            ->get();

        return view('indikator_anemia.index', [
            'title'           => 'Jumlah Ibu Hamil Anemia',
            'items'           => $items,
            'selected_year'   => $year,
            'available_years' => $availableYears,
        ]);
    }

    public function create(Request $request)
    {
        $returnYear = (int) $request->query('tahun', now()->year);

        return view('indikator_anemia.form', [
            'title'       => 'Tambah Jumlah Ibu Hamil Anemia',
            'item'        => new IbuHamilAnemia(),
            'isEdit'      => false,
            'action'      => route('ibu-hamil-anemia.store'),
            'method'      => 'POST',
            'return_year' => $returnYear,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tahun'       => ['required', 'integer', 'min:2000', 'max:2100'],
            'bulan'       => ['required', 'integer', 'min:1', 'max:12'],
            'jumlah'      => ['required', 'integer', 'min:0'],
            'return_year' => ['nullable', 'integer'],
        ]);

        // biar tidak dobel (tahun+bulan unik) -> update kalau sudah ada
        IbuHamilAnemia::updateOrCreate(
            ['tahun' => $data['tahun'], 'bulan' => $data['bulan']],
            ['jumlah' => $data['jumlah']]
        );

        return redirect()
            ->route('ibu-hamil-anemia.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data berhasil disimpan.');
    }

    public function edit(Request $request, IbuHamilAnemia $ibu_hamil_anemia)
    {
        $returnYear = (int) $request->query('tahun', $ibu_hamil_anemia->tahun);

        return view('indikator_anemia.form', [
            'title'       => 'Edit Jumlah Ibu Hamil Anemia',
            'item'        => $ibu_hamil_anemia,
            'isEdit'      => true,
            'action'      => route('ibu-hamil-anemia.update', $ibu_hamil_anemia->id),
            'method'      => 'PUT',
            'return_year' => $returnYear,
        ]);
    }

    public function update(Request $request, IbuHamilAnemia $ibu_hamil_anemia)
    {
        $data = $request->validate([
            'tahun'       => ['required', 'integer', 'min:2000', 'max:2100'],
            'bulan'       => ['required', 'integer', 'min:1', 'max:12'],
            'jumlah'      => ['required', 'integer', 'min:0'],
            'return_year' => ['nullable', 'integer'],
        ]);

        // kalau user ganti tahun+bulan dan ternyata sudah ada record lain -> update record itu
        $existing = IbuHamilAnemia::where('tahun', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->where('id', '!=', $ibu_hamil_anemia->id)
            ->first();

        if ($existing) {
            $existing->update(['jumlah' => $data['jumlah']]);
            $ibu_hamil_anemia->delete();
        } else {
            $ibu_hamil_anemia->update($data);
        }

        return redirect()
            ->route('ibu-hamil-anemia.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Request $request, IbuHamilAnemia $ibu_hamil_anemia)
    {
        $returnYear = (int) $request->query('tahun', $ibu_hamil_anemia->tahun ?? now()->year);
        $ibu_hamil_anemia->delete();

        return redirect()
            ->route('ibu-hamil-anemia.index', ['tahun' => $returnYear])
            ->with('success', 'Data berhasil dihapus.');
    }
}
