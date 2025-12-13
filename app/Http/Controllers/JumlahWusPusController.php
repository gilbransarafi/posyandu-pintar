<?php

namespace App\Http\Controllers;

use App\Models\JumlahWusPus;
use Illuminate\Http\Request;

class JumlahWusPusController extends Controller
{
    public function index()
    {
        $items = JumlahWusPus::orderBy('year', 'desc')->get();

        return view('indikator.index', [
            'title'       => 'Jumlah WUS / PUS',
            'routePrefix' => 'wus-pus',
            'items'       => $items,
        ]);
    }

    public function create()
    {
        return view('indikator.form', [
            'title'       => 'Tambah Jumlah WUS / PUS',
            'routePrefix' => 'wus-pus',
            'item'        => null,
            'isEdit'      => false,
            'formAction'  => route('wus-pus.store'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year'   => 'required|integer|min:2000|max:2100',
            'male'   => 'required|integer|min:0',
            'female' => 'required|integer|min:0',
        ]);

        JumlahWusPus::updateOrCreate(
            ['year' => $data['year']],
            ['male' => $data['male'], 'female' => $data['female']]
        );

        return redirect()->route('wus-pus.index')
            ->with('success', 'Data Jumlah WUS/PUS berhasil disimpan.');
    }

    public function edit(JumlahWusPus $wus_pus)
    {
        return view('indikator.form', [
            'title'       => 'Edit Jumlah WUS / PUS',
            'routePrefix' => 'wus-pus',
            'item'        => $wus_pus,
            'isEdit'      => true,
            'formAction'  => route('wus-pus.update', $wus_pus->id),
        ]);
    }

    public function update(Request $request, JumlahWusPus $wus_pus)
    {
        $data = $request->validate([
            'year'   => 'required|integer|min:2000|max:2100',
            'male'   => 'required|integer|min:0',
            'female' => 'required|integer|min:0',
        ]);

        $wus_pus->update($data);

        return redirect()->route('wus-pus.index')
            ->with('success', 'Data Jumlah WUS/PUS berhasil diperbarui.');
    }

    public function destroy(JumlahWusPus $wus_pus)
    {
        $wus_pus->delete();

        return redirect()->route('wus-pus.index')
            ->with('success', 'Data Jumlah WUS/PUS berhasil dihapus.');
    }
}
