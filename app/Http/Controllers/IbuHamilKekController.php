<?php

namespace App\Http\Controllers;

use App\Models\IbuHamilKek;
use Illuminate\Http\Request;

class IbuHamilKekController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('tahun', now()->year);

        $availableYears = IbuHamilKek::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (! in_array($year, $availableYears, true)) {
            $availableYears[] = $year;
            rsort($availableYears);
        }

        $items = IbuHamilKek::where('tahun', $year)
            ->orderBy('bulan', 'asc')
            ->get();

        return view('indikator_kek.index', [
            'title'           => 'Jumlah Ibu Hamil KEK',
            'items'           => $items,
            'selected_year'   => $year,
            'available_years' => $availableYears,
        ]);
    }

    public function create(Request $request)
    {
        $returnYear = (int) $request->query('tahun', now()->year);

        return view('indikator_kek.form', [
            'title'       => 'Tambah Jumlah Ibu Hamil KEK',
            'item'        => new IbuHamilKek(),
            'isEdit'      => false,
            'action'      => route('ibu-hamil-kek.store'),
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

        IbuHamilKek::updateOrCreate(
            ['tahun' => $data['tahun'], 'bulan' => $data['bulan']],
            ['jumlah' => $data['jumlah']]
        );

        return redirect()->route('ibu-hamil-kek.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data berhasil disimpan.');
    }

    public function edit(Request $request, IbuHamilKek $ibu_hamil_kek)
    {
        $returnYear = (int) $request->query('tahun', $ibu_hamil_kek->tahun);

        return view('indikator_kek.form', [
            'title'       => 'Edit Jumlah Ibu Hamil KEK',
            'item'        => $ibu_hamil_kek,
            'isEdit'      => true,
            'action'      => route('ibu-hamil-kek.update', $ibu_hamil_kek->id),
            'return_year' => $returnYear,
        ]);
    }

    public function update(Request $request, IbuHamilKek $ibu_hamil_kek)
    {
        $data = $request->validate([
            'tahun'       => ['required', 'integer', 'min:2000', 'max:2100'],
            'bulan'       => ['required', 'integer', 'min:1', 'max:12'],
            'jumlah'      => ['required', 'integer', 'min:0'],
            'return_year' => ['nullable', 'integer'],
        ]);

        $existing = IbuHamilKek::where('tahun', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->where('id', '!=', $ibu_hamil_kek->id)
            ->first();

        if ($existing) {
            $existing->update(['jumlah' => $data['jumlah']]);
            $ibu_hamil_kek->delete();
        } else {
            $ibu_hamil_kek->update($data);
        }

        return redirect()->route('ibu-hamil-kek.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Request $request, IbuHamilKek $ibu_hamil_kek)
    {
        $returnYear = (int) $request->query('tahun', $ibu_hamil_kek->tahun ?? now()->year);
        $ibu_hamil_kek->delete();

        return redirect()->route('ibu-hamil-kek.index', ['tahun' => $returnYear])
            ->with('success', 'Data berhasil dihapus.');
    }
}
