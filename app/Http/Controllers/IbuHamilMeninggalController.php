<?php

namespace App\Http\Controllers;

use App\Models\IbuHamilMeninggal;
use Illuminate\Http\Request;

class IbuHamilMeninggalController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('tahun', now()->year);

        $availableYears = IbuHamilMeninggal::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (! in_array($year, $availableYears, true)) {
            $availableYears[] = $year;
            rsort($availableYears);
        }

        $items = IbuHamilMeninggal::where('tahun', $year)
            ->orderByRaw("FIELD(bulan,'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        return view('ibu_hamil_meninggal.index', [
            'title'           => 'Jumlah Ibu Hamil yang Meninggal (Kehamilan/Persalinan)',
            'items'           => $items,
            'selected_year'   => $year,
            'available_years' => $availableYears,
        ]);
    }

    public function create(Request $request)
    {
        $returnYear = (int) $request->query('tahun', now()->year);

        return view('ibu_hamil_meninggal.form', [
            'title'       => 'Tambah Data Ibu Hamil Meninggal',
            'isEdit'      => false,
            'item'        => null,
            'formAction'  => route('ibu-hamil-meninggal.store'),
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

        // Cegah dobel tahun+bulan
        $exists = IbuHamilMeninggal::where('tahun', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'bulan' => 'Data untuk tahun & bulan ini sudah ada. Silakan edit data yang ada.',
            ]);
        }

        IbuHamilMeninggal::create([
            'tahun'  => $data['tahun'],
            'bulan'  => $data['bulan'],
            'jumlah' => $data['jumlah'],
        ]);

        return redirect()->route('ibu-hamil-meninggal.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(Request $request, IbuHamilMeninggal $ibu_hamil_meninggal)
    {
        $returnYear = (int) $request->query('tahun', $ibu_hamil_meninggal->tahun);

        return view('ibu_hamil_meninggal.form', [
            'title'       => 'Edit Data Ibu Hamil Meninggal',
            'isEdit'      => true,
            'item'        => $ibu_hamil_meninggal,
            'formAction'  => route('ibu-hamil-meninggal.update', $ibu_hamil_meninggal->id),
            'return_year' => $returnYear,
        ]);
    }

    public function update(Request $request, IbuHamilMeninggal $ibu_hamil_meninggal)
    {
        $data = $request->validate([
            'tahun'       => 'required|integer|min:2000|max:2100',
            'bulan'       => 'required|string|max:20',
            'jumlah'      => 'required|integer|min:0',
            'return_year' => 'nullable|integer',
        ]);

        $exists = IbuHamilMeninggal::where('tahun', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->where('id', '!=', $ibu_hamil_meninggal->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'bulan' => 'Data untuk tahun & bulan ini sudah ada.',
            ]);
        }

        $ibu_hamil_meninggal->update([
            'tahun'  => $data['tahun'],
            'bulan'  => $data['bulan'],
            'jumlah' => $data['jumlah'],
        ]);

        return redirect()->route('ibu-hamil-meninggal.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Request $request, IbuHamilMeninggal $ibu_hamil_meninggal)
    {
        $returnYear = (int) $request->query('tahun', $ibu_hamil_meninggal->tahun ?? now()->year);

        $ibu_hamil_meninggal->delete();

        return redirect()->route('ibu-hamil-meninggal.index', ['tahun' => $returnYear])
            ->with('success', 'Data berhasil dihapus.');
    }
}
