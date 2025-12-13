<?php

namespace App\Http\Controllers;

use App\Models\JumlahIbuHamil;
use Illuminate\Http\Request;

class JumlahIbuHamilController extends Controller
{
    public function index()
    {
        $items = JumlahIbuHamil::orderBy('year', 'desc')->get();

        return view('indikator.index', [
            'title'       => 'Jumlah Ibu Hamil',
            'routePrefix' => 'ibu-hamil',
            'items'       => $items,
        ]);
    }

    public function create()
    {
        return view('indikator.form', [
            'title'       => 'Tambah Jumlah Ibu Hamil',
            'routePrefix' => 'ibu-hamil',
            'item'        => null,
            'isEdit'      => false,
            'formAction'  => route('ibu-hamil.store'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year'   => 'required|integer|min:2000|max:2100',
            'male'   => 'required|integer|min:0',
            'female' => 'required|integer|min:0',
        ]);

        JumlahIbuHamil::updateOrCreate(
            ['year' => $data['year']],
            ['male' => $data['male'], 'female' => $data['female']]
        );

        return redirect()->route('ibu-hamil.index')
            ->with('success', 'Data Ibu Hamil berhasil disimpan.');
    }

    public function edit(JumlahIbuHamil $ibu_hamil)
    {
        return view('indikator.form', [
            'title'       => 'Edit Jumlah Ibu Hamil',
            'routePrefix' => 'ibu-hamil',
            'item'        => $ibu_hamil,
            'isEdit'      => true,
            'formAction'  => route('ibu-hamil.update', $ibu_hamil->id),
        ]);
    }

    public function update(Request $request, JumlahIbuHamil $ibu_hamil)
    {
        $data = $request->validate([
            'year'   => 'required|integer|min:2000|max:2100',
            'male'   => 'required|integer|min:0',
            'female' => 'required|integer|min:0',
        ]);

        $ibu_hamil->update($data);

        return redirect()->route('ibu-hamil.index')
            ->with('success', 'Data Ibu Hamil berhasil diperbarui.');
    }

    public function destroy(JumlahIbuHamil $ibu_hamil)
    {
        $ibu_hamil->delete();

        return redirect()->route('ibu-hamil.index')
            ->with('success', 'Data Ibu Hamil berhasil dihapus.');
    }
}
