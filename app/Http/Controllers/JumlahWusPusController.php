<?php
namespace App\Http\Controllers;

use App\Models\JumlahWusPus;
use Illuminate\Http\Request;

class JumlahWusPusController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('tahun', now()->year);

        $availableYears = JumlahWusPus::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (! in_array($year, $availableYears, true)) {
            $availableYears[] = $year;
            rsort($availableYears);
        }

        $items = JumlahWusPus::where('year', $year)
            ->orderByRaw("FIELD(bulan,'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        return view('wus_pus.index', [
            'title'           => 'Jumlah WUS / PUS',
            'items'           => $items,
            'selected_year'   => $year,
            'available_years' => $availableYears,
        ]);
    }

    public function create(Request $request)
    {
        $returnYear = (int) $request->query('tahun', now()->year);

        return view('wus_pus.form', [
            'title'       => 'Tambah Data WUS / PUS',
            'isEdit'      => false,
            'item'        => null,
            'formAction'  => route('wus-pus.store'),
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

        $exists = JumlahWusPus::where('year', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'bulan' => 'Data untuk tahun & bulan ini sudah ada. Silakan edit data yang ada.',
            ]);
        }

        JumlahWusPus::create([
            'year'   => $data['tahun'],
            'bulan'  => $data['bulan'],
            'jumlah' => $data['jumlah'],
        ]);

        return redirect()->route('wus-pus.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data Jumlah WUS/PUS berhasil disimpan.');
    }

    public function edit(Request $request, JumlahWusPus $wus_pus)
    {
        $returnYear = (int) $request->query('tahun', $wus_pus->year);

        return view('wus_pus.form', [
            'title'       => 'Edit Data WUS / PUS',
            'isEdit'      => true,
            'item'        => $wus_pus,
            'formAction'  => route('wus-pus.update', $wus_pus->id),
            'return_year' => $returnYear,
        ]);
    }

    public function update(Request $request, JumlahWusPus $wus_pus)
    {
        $data = $request->validate([
            'tahun'       => 'required|integer|min:2000|max:2100',
            'bulan'       => 'required|string|max:20',
            'jumlah'      => 'required|integer|min:0',
            'return_year' => 'nullable|integer',
        ]);

        $exists = JumlahWusPus::where('year', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->where('id', '!=', $wus_pus->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'bulan' => 'Data untuk tahun & bulan ini sudah ada.',
            ]);
        }

        $wus_pus->update([
            'year'   => $data['tahun'],
            'bulan'  => $data['bulan'],
            'jumlah' => $data['jumlah'],
        ]);

        return redirect()->route('wus-pus.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data Jumlah WUS/PUS berhasil diperbarui.');
    }

    public function destroy(Request $request, JumlahWusPus $wus_pus)
    {
        $returnYear = (int) $request->query('tahun', $wus_pus->year ?? now()->year);

        $wus_pus->delete();

        return redirect()->route('wus-pus.index', ['tahun' => $returnYear])
            ->with('success', 'Data Jumlah WUS/PUS berhasil dihapus.');
    }
}
