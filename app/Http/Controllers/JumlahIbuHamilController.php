<?php

namespace App\Http\Controllers;

use App\Models\JumlahIbuHamil;
use Illuminate\Http\Request;

class JumlahIbuHamilController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('tahun', now()->year);

        $availableYears = JumlahIbuHamil::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (! in_array($year, $availableYears, true)) {
            $availableYears[] = $year;
            rsort($availableYears);
        }

        $items = JumlahIbuHamil::where('year', $year)
            ->orderByRaw("FIELD(bulan,'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        return view('ibu_hamil.index', [
            'title'           => 'Jumlah Ibu Hamil',
            'items'           => $items,
            'selected_year'   => $year,
            'available_years' => $availableYears,
        ]);
    }

    public function create(Request $request)
    {
        $returnYear = (int) $request->query('tahun', now()->year);

        return view('ibu_hamil.form', [
            'title'       => 'Tambah Jumlah Ibu Hamil',
            'isEdit'      => false,
            'item'        => null,
            'formAction'  => route('ibu-hamil.store'),
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

        $exists = JumlahIbuHamil::where('year', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'bulan' => 'Data untuk tahun & bulan ini sudah ada. Silakan edit data yang ada.',
            ]);
        }

        JumlahIbuHamil::create([
            'year'   => $data['tahun'],
            'bulan'  => $data['bulan'],
            'jumlah' => $data['jumlah'],
        ]);

        return redirect()->route('ibu-hamil.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data Ibu Hamil berhasil disimpan.');
    }

    public function edit(Request $request, JumlahIbuHamil $ibu_hamil)
    {
        $returnYear = (int) $request->query('tahun', $ibu_hamil->year);

        return view('ibu_hamil.form', [
            'title'       => 'Edit Jumlah Ibu Hamil',
            'isEdit'      => true,
            'item'        => $ibu_hamil,
            'formAction'  => route('ibu-hamil.update', $ibu_hamil->id),
            'return_year' => $returnYear,
        ]);
    }

    public function update(Request $request, JumlahIbuHamil $ibu_hamil)
    {
        $data = $request->validate([
            'tahun'       => 'required|integer|min:2000|max:2100',
            'bulan'       => 'required|string|max:20',
            'jumlah'      => 'required|integer|min:0',
            'return_year' => 'nullable|integer',
        ]);

        $exists = JumlahIbuHamil::where('year', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->where('id', '!=', $ibu_hamil->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'bulan' => 'Data untuk tahun & bulan ini sudah ada.',
            ]);
        }

        $ibu_hamil->update([
            'year'   => $data['tahun'],
            'bulan'  => $data['bulan'],
            'jumlah' => $data['jumlah'],
        ]);

        return redirect()->route('ibu-hamil.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data Ibu Hamil berhasil diperbarui.');
    }

    public function destroy(Request $request, JumlahIbuHamil $ibu_hamil)
    {
        $returnYear = (int) $request->query('tahun', $ibu_hamil->year ?? now()->year);

        $ibu_hamil->delete();

        return redirect()->route('ibu-hamil.index', ['tahun' => $returnYear])
            ->with('success', 'Data Ibu Hamil berhasil dihapus.');
    }
}
