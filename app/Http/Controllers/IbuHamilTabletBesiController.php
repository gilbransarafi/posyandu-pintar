<?php

namespace App\Http\Controllers;

use App\Models\IbuHamilTabletBesi;
use Illuminate\Http\Request;

class IbuHamilTabletBesiController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('year', now()->year);

        $availableYears = IbuHamilTabletBesi::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (! in_array($year, $availableYears, true)) {
            $availableYears[] = $year;
            rsort($availableYears);
        }

        $items = IbuHamilTabletBesi::where('tahun', $year)
            ->orderByRaw("FIELD(bulan,'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        return view('ibu_hamil_tablet_besi.index', [
            'title' => 'Ibu Hamil Mendapat Tablet Besi (FE I / FE III)',
            'year'  => $year,
            'items' => $items,
            'available_years' => $availableYears,
        ]);
    }

    public function create(Request $request)
    {
        $year = (int) $request->input('year', now()->year);

        return view('ibu_hamil_tablet_besi.form', [
            'title'      => 'Tambah Data FE I / FE III',
            'isEdit'     => false,
            'item'       => null,
            'formAction' => route('ibu-hamil-tablet-besi.store'),
            'year'       => $year,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'bulan' => ['required', 'string', 'max:20'],
            'fe1'   => ['required', 'integer', 'min:0'],
            'fe3'   => ['required', 'integer', 'min:0'],
        ]);

        // Supaya tidak dobel data pada tahun+bulan yang sama
        $exists = IbuHamilTabletBesi::where('tahun', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['bulan' => 'Data untuk tahun & bulan ini sudah ada. Silakan edit data yang ada.']);
        }

        IbuHamilTabletBesi::create($data);

        return redirect()
            ->route('ibu-hamil-tablet-besi.index', ['year' => $data['tahun']])
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(IbuHamilTabletBesi $ibu_hamil_tablet_besi)
    {
        return view('ibu_hamil_tablet_besi.form', [
            'title'      => 'Edit Data FE I / FE III',
            'isEdit'     => true,
            'item'       => $ibu_hamil_tablet_besi,
            'formAction' => route('ibu-hamil-tablet-besi.update', $ibu_hamil_tablet_besi->id),
            'year'       => $ibu_hamil_tablet_besi->tahun,
        ]);
    }

    public function update(Request $request, IbuHamilTabletBesi $ibu_hamil_tablet_besi)
    {
        $data = $request->validate([
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'bulan' => ['required', 'string', 'max:20'],
            'fe1'   => ['required', 'integer', 'min:0'],
            'fe3'   => ['required', 'integer', 'min:0'],
        ]);

        // Cegah dobel tahun+bulan selain record ini
        $exists = IbuHamilTabletBesi::where('tahun', $data['tahun'])
            ->where('bulan', $data['bulan'])
            ->where('id', '!=', $ibu_hamil_tablet_besi->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['bulan' => 'Data untuk tahun & bulan ini sudah ada.']);
        }

        $ibu_hamil_tablet_besi->update($data);

        return redirect()
            ->route('ibu-hamil-tablet-besi.index', ['year' => $data['tahun']])
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(IbuHamilTabletBesi $ibu_hamil_tablet_besi)
    {
        $year = $ibu_hamil_tablet_besi->tahun;
        $ibu_hamil_tablet_besi->delete();

        return redirect()
            ->route('ibu-hamil-tablet-besi.index', ['year' => $year])
            ->with('success', 'Data berhasil dihapus.');
    }
}
