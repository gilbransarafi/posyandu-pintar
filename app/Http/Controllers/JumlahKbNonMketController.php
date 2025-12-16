<?php

namespace App\Http\Controllers;

use App\Models\JumlahKbNonMket;
use Illuminate\Http\Request;

class JumlahKbNonMketController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('tahun', now()->year);

        $availableYears = JumlahKbNonMket::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (! in_array($year, $availableYears, true)) {
            $availableYears[] = $year;
            rsort($availableYears);
        }

        $items = JumlahKbNonMket::where('year', $year)
            ->orderByRaw("FIELD(bulan,'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        return view('kb_non_mket.index', [
            'title'           => 'Jumlah peserta KB non MKET (Suntik/Pil/Kondom)',
            'items'           => $items,
            'selected_year'   => $year,
            'available_years' => $availableYears,
        ]);
    }

    public function create(Request $request)
    {
        $returnYear = (int) $request->query('tahun', now()->year);

        return view('kb_non_mket.form', [
            'title'       => 'Tambah Jumlah peserta KB non MKET',
            'isEdit'      => false,
            'item'        => null,
            'formAction'  => route('kb-non-mket.store'),
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

        $exists = JumlahKbNonMket::where('year', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'bulan' => 'Data untuk tahun & bulan ini sudah ada. Silakan edit data yang ada.',
            ]);
        }

        JumlahKbNonMket::create([
            'year'   => $data['tahun'],
            'bulan'  => $data['bulan'],
            'jumlah' => $data['jumlah'],
        ]);

        return redirect()->route('kb-non-mket.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data KB non MKET berhasil disimpan.');
    }

    public function edit(Request $request, JumlahKbNonMket $kb_non_mket)
    {
        $returnYear = (int) $request->query('tahun', $kb_non_mket->year);

        return view('kb_non_mket.form', [
            'title'       => 'Edit Jumlah peserta KB non MKET',
            'isEdit'      => true,
            'item'        => $kb_non_mket,
            'formAction'  => route('kb-non-mket.update', $kb_non_mket->id),
            'return_year' => $returnYear,
        ]);
    }

    public function update(Request $request, JumlahKbNonMket $kb_non_mket)
    {
        $data = $request->validate([
            'tahun'       => 'required|integer|min:2000|max:2100',
            'bulan'       => 'required|string|max:20',
            'jumlah'      => 'required|integer|min:0',
            'return_year' => 'nullable|integer',
        ]);

        $exists = JumlahKbNonMket::where('year', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->where('id', '!=', $kb_non_mket->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'bulan' => 'Data untuk tahun & bulan ini sudah ada.',
            ]);
        }

        $kb_non_mket->update([
            'year'   => $data['tahun'],
            'bulan'  => $data['bulan'],
            'jumlah' => $data['jumlah'],
        ]);

        return redirect()->route('kb-non-mket.index', ['tahun' => $data['tahun']])
            ->with('success', 'Data KB non MKET berhasil diperbarui.');
    }

    public function destroy(Request $request, JumlahKbNonMket $kb_non_mket)
    {
        $returnYear = (int) $request->query('tahun', $kb_non_mket->year ?? now()->year);

        $kb_non_mket->delete();

        return redirect()->route('kb-non-mket.index', ['tahun' => $returnYear])
            ->with('success', 'Data KB non MKET berhasil dihapus.');
    }
}
