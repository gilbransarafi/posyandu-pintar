<?php
namespace App\Http\Controllers;

use App\Models\JumlahPusKb;
use Illuminate\Http\Request;

class JumlahPusKbController extends Controller
{
    public function index()
    {
        $items = JumlahPusKb::orderBy('year', 'desc')->get();

        return view('indikator.index', [
            'title'       => 'Jumlah PUS ikut KB',
            'routePrefix' => 'pus-kb',
            'items'       => $items,
        ]);
    }

    public function create()
    {
        return view('indikator.form', [
            'title'       => 'Tambah Jumlah PUS ikut KB',
            'routePrefix' => 'pus-kb',
            'item'        => null,
            'isEdit'      => false,
            'formAction'  => route('pus-kb.store'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year'   => 'required|integer|min:2000|max:2100',
            'male'   => 'required|integer|min:0',
            'female' => 'required|integer|min:0',
        ]);

        JumlahPusKb::updateOrCreate(
            ['year' => $data['year']],
            ['male' => $data['male'], 'female' => $data['female']]
        );

        return redirect()->route('pus-kb.index')
            ->with('success', 'Data Jumlah PUS ikut KB berhasil disimpan.');
    }

    public function edit(JumlahPusKb $pus_kb)
    {
        return view('indikator.form', [
            'title'       => 'Edit Jumlah PUS ikut KB',
            'routePrefix' => 'pus-kb',
            'item'        => $pus_kb,
            'isEdit'      => true,
            'formAction'  => route('pus-kb.update', $pus_kb->id),
        ]);
    }

    public function update(Request $request, JumlahPusKb $pus_kb)
    {
        $data = $request->validate([
            'year'   => 'required|integer|min:2000|max:2100',
            'male'   => 'required|integer|min:0',
            'female' => 'required|integer|min:0',
        ]);

        $pus_kb->update($data);

        return redirect()->route('pus-kb.index')
            ->with('success', 'Data Jumlah PUS ikut KB berhasil diperbarui.');
    }

    public function destroy(JumlahPusKb $pus_kb)
    {
        $pus_kb->delete();

        return redirect()->route('pus-kb.index')
            ->with('success', 'Data Jumlah PUS ikut KB berhasil dihapus.');
    }
}
