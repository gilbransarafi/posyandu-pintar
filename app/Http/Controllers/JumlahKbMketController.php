<?php

namespace App\Http\Controllers;

use App\Models\JumlahKbMket;
use Illuminate\Http\Request;

class JumlahKbMketController extends Controller
{
    public function index()
    {
        $items = JumlahKbMket::orderBy('year', 'desc')->get();

        return view('indikator.index', [
            'title'       => 'Jumlah peserta KB MKET (MOP/MOW/IUD/Implant)',
            'routePrefix' => 'kb-mket',
            'items'       => $items,
        ]);
    }

    public function create()
    {
        return view('indikator.form', [
            'title'       => 'Tambah Jumlah peserta KB MKET',
            'routePrefix' => 'kb-mket',
            'item'        => null,
            'isEdit'      => false,
            'formAction'  => route('kb-mket.store'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year'   => 'required|integer|min:2000|max:2100',
            'male'   => 'required|integer|min:0',
            'female' => 'required|integer|min:0',
        ]);

        JumlahKbMket::updateOrCreate(
            ['year' => $data['year']],
            ['male' => $data['male'], 'female' => $data['female']]
        );

        return redirect()->route('kb-mket.index')
            ->with('success', 'Data KB MKET berhasil disimpan.');
    }

    public function edit(JumlahKbMket $kb_mket)
    {
        return view('indikator.form', [
            'title'       => 'Edit Jumlah peserta KB MKET',
            'routePrefix' => 'kb-mket',
            'item'        => $kb_mket,
            'isEdit'      => true,
            'formAction'  => route('kb-mket.update', $kb_mket->id),
        ]);
    }

    public function update(Request $request, JumlahKbMket $kb_mket)
    {
        $data = $request->validate([
            'year'   => 'required|integer|min:2000|max:2100',
            'male'   => 'required|integer|min:0',
            'female' => 'required|integer|min:0',
        ]);

        $kb_mket->update($data);

        return redirect()->route('kb-mket.index')
            ->with('success', 'Data KB MKET berhasil diperbarui.');
    }

    public function destroy(JumlahKbMket $kb_mket)
    {
        $kb_mket->delete();

        return redirect()->route('kb-mket.index')
            ->with('success', 'Data KB MKET berhasil dihapus.');
    }
}
