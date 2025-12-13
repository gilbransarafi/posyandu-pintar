<?php

namespace App\Http\Controllers;

use App\Models\JumlahKbNonMket;
use Illuminate\Http\Request;

class JumlahKbNonMketController extends Controller
{
    public function index()
    {
        $items = JumlahKbNonMket::orderBy('year', 'desc')->get();

        return view('indikator.index', [
            'title'       => 'Jumlah peserta KB non MKET (Suntik/Pil/Kondom)',
            'routePrefix' => 'kb-non-mket',
            'items'       => $items,
        ]);
    }

    public function create()
    {
        return view('indikator.form', [
            'title'       => 'Tambah Jumlah peserta KB non MKET',
            'routePrefix' => 'kb-non-mket',
            'item'        => null,
            'isEdit'      => false,
            'formAction'  => route('kb-non-mket.store'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year'   => 'required|integer|min:2000|max:2100',
            'male'   => 'required|integer|min:0',
            'female' => 'required|integer|min:0',
        ]);

        JumlahKbNonMket::updateOrCreate(
            ['year' => $data['year']],
            ['male' => $data['male'], 'female' => $data['female']]
        );

        return redirect()->route('kb-non-mket.index')
            ->with('success', 'Data KB non MKET berhasil disimpan.');
    }

    public function edit(JumlahKbNonMket $kb_non_mket)
    {
        return view('indikator.form', [
            'title'       => 'Edit Jumlah peserta KB non MKET',
            'routePrefix' => 'kb-non-mket',
            'item'        => $kb_non_mket,
            'isEdit'      => true,
            'formAction'  => route('kb-non-mket.update', $kb_non_mket->id),
        ]);
    }

    public function update(Request $request, JumlahKbNonMket $kb_non_mket)
    {
        $data = $request->validate([
            'year'   => 'required|integer|min:2000|max:2100',
            'male'   => 'required|integer|min:0',
            'female' => 'required|integer|min:0',
        ]);

        $kb_non_mket->update($data);

        return redirect()->route('kb-non-mket.index')
            ->with('success', 'Data KB non MKET berhasil diperbarui.');
    }

    public function destroy(JumlahKbNonMket $kb_non_mket)
    {
        $kb_non_mket->delete();

        return redirect()->route('kb-non-mket.index')
            ->with('success', 'Data KB non MKET berhasil dihapus.');
    }
}
