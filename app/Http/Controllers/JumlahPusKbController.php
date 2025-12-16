<?php
namespace App\Http\Controllers;

use App\Models\JumlahPusKb;
use Illuminate\Http\Request;

class JumlahPusKbController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('tahun', now()->year);

        $availableYears = JumlahPusKb::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (! in_array($year, $availableYears, true)) {
            $availableYears[] = $year;
            rsort($availableYears);
        }

        $items = JumlahPusKb::where('year', $year)
            ->orderByRaw("FIELD(bulan,'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        return view('pus_kb.index', [
            'title'           => 'Jumlah PUS ikut KB',
            'items'           => $items,
            'selected_year'   => $year,
            'available_years' => $availableYears,
        ]);
    }

    public function create(Request $request)
    {
        $returnYear = (int) $request->query('tahun', now()->year);

        return view('pus_kb.form', [
            'title'       => 'Tambah Data PUS ikut KB',
            'isEdit'      => false,
            'item'        => null,
            'formAction'  => route('pus-kb.store'),
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

        $exists = JumlahPusKb::where('year', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'bulan' => 'Data untuk tahun & bulan ini sudah ada. Silakan edit data yang ada.',
            ]);
        }

        JumlahPusKb::create([
            'year'   => $data['tahun'],
            'bulan'  => $data['bulan'],
            'jumlah' => $data['jumlah'],
        ]);

        return redirect()->route('pus-kb.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data Jumlah PUS ikut KB berhasil disimpan.');
    }

    public function edit(Request $request, JumlahPusKb $pus_kb)
    {
        $returnYear = (int) $request->query('tahun', $pus_kb->year);

        return view('pus_kb.form', [
            'title'       => 'Edit Data PUS ikut KB',
            'isEdit'      => true,
            'item'        => $pus_kb,
            'formAction'  => route('pus-kb.update', $pus_kb->id),
            'return_year' => $returnYear,
        ]);
    }

    public function update(Request $request, JumlahPusKb $pus_kb)
    {
        $data = $request->validate([
            'tahun'       => 'required|integer|min:2000|max:2100',
            'bulan'       => 'required|string|max:20',
            'jumlah'      => 'required|integer|min:0',
            'return_year' => 'nullable|integer',
        ]);

        $exists = JumlahPusKb::where('year', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->where('id', '!=', $pus_kb->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'bulan' => 'Data untuk tahun & bulan ini sudah ada.',
            ]);
        }

        $pus_kb->update([
            'year'   => $data['tahun'],
            'bulan'  => $data['bulan'],
            'jumlah' => $data['jumlah'],
        ]);

        return redirect()->route('pus-kb.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data Jumlah PUS ikut KB berhasil diperbarui.');
    }

    public function destroy(Request $request, JumlahPusKb $pus_kb)
    {
        $returnYear = (int) $request->query('tahun', $pus_kb->year ?? now()->year);

        $pus_kb->delete();

        return redirect()->route('pus-kb.index', ['tahun' => $returnYear])
            ->with('success', 'Data Jumlah PUS ikut KB berhasil dihapus.');
    }
}
