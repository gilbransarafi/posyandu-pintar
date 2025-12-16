<?php

namespace App\Http\Controllers;

use App\Models\IbuHamilRisikoTinggi;
use Illuminate\Http\Request;

class IbuHamilRisikoTinggiController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('tahun', now()->year);

        $availableYears = IbuHamilRisikoTinggi::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (!in_array($year, $availableYears, true)) {
            $availableYears[] = $year;
            rsort($availableYears);
        }

        $items = IbuHamilRisikoTinggi::where('tahun', $year)
            ->orderByRaw("FIELD(bulan,'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        return view('ibu_hamil_risiko_tinggi.index', [
            'title'           => 'Ibu Hamil Risiko Tinggi',
            'items'           => $items,
            'selected_year'   => $year,
            'available_years' => $availableYears,
        ]);
    }

    public function create(Request $request)
    {
        $returnYear = (int) $request->query('tahun', now()->year);

        return view('ibu_hamil_risiko_tinggi.form', [
            'title'       => 'Tambah Data Ibu Hamil Risiko Tinggi',
            'isEdit'      => false,
            'item'        => null,
            'formAction'  => route('ibu-hamil-risiko-tinggi.store'),
            'return_year' => $returnYear,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tahun'       => 'required|integer|min:2000|max:2100',
            'bulan'       => 'required|string|max:20',
            'jumlah'      => 'required|integer|min:0',
            'return_year' => 'nullable|integer',
        ]);

        $exists = IbuHamilRisikoTinggi::where('tahun', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'bulan' => 'Data untuk tahun & bulan ini sudah ada. Silakan edit data yang ada.',
            ]);
        }

        IbuHamilRisikoTinggi::create([
            'tahun'  => $data['tahun'],
            'bulan'  => $data['bulan'],
            'jumlah' => $data['jumlah'],
        ]);

        // ✅ balik ke tahun yang baru disimpan
        return redirect()->route('ibu-hamil-risiko-tinggi.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(Request $request, IbuHamilRisikoTinggi $ibu_hamil_risiko_tinggi)
    {
        $returnYear = (int) $request->query('tahun', $ibu_hamil_risiko_tinggi->tahun);

        return view('ibu_hamil_risiko_tinggi.form', [
            'title'       => 'Edit Data Ibu Hamil Risiko Tinggi',
            'isEdit'      => true,
            'item'        => $ibu_hamil_risiko_tinggi,
            'formAction'  => route('ibu-hamil-risiko-tinggi.update', $ibu_hamil_risiko_tinggi->id),
            'return_year' => $returnYear,
        ]);
    }

    public function update(Request $request, IbuHamilRisikoTinggi $ibu_hamil_risiko_tinggi)
    {
        $data = $request->validate([
            'tahun'       => 'required|integer|min:2000|max:2100',
            'bulan'       => 'required|string|max:20',
            'jumlah'      => 'required|integer|min:0',
            'return_year' => 'nullable|integer',
        ]);

        $exists = IbuHamilRisikoTinggi::where('tahun', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->where('id', '!=', $ibu_hamil_risiko_tinggi->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'bulan' => 'Data untuk tahun & bulan ini sudah ada.',
            ]);
        }

        $ibu_hamil_risiko_tinggi->update([
            'tahun'  => $data['tahun'],
            'bulan'  => $data['bulan'],
            'jumlah' => $data['jumlah'],
        ]);

        // ✅ balik ke tahun yang sedang diedit (tahun baru)
        return redirect()->route('ibu-hamil-risiko-tinggi.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Request $request, IbuHamilRisikoTinggi $ibu_hamil_risiko_tinggi)
    {
        $returnYear = (int) $request->query('tahun', $ibu_hamil_risiko_tinggi->tahun);

        $ibu_hamil_risiko_tinggi->delete();

        return redirect()->route('ibu-hamil-risiko-tinggi.index', ['tahun' => $returnYear])
            ->with('success', 'Data berhasil dihapus.');
    }
}
