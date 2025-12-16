<?php

namespace App\Http\Controllers;

use App\Models\JumlahBayiBalita;
use Illuminate\Http\Request;

class JumlahBayiBalitaController extends Controller
{
    private array $usiaOptions = [
        '0-11 Bulan',
        '12-23 Bulan',
        '24-59 Bulan',
    ];

    public function index()
    {
        $items = JumlahBayiBalita::orderBy('tahun', 'desc')
            ->orderBy('usia_kategori', 'asc')
            ->get();

        return view('bayi_balita.index', [
            'title' => 'Jumlah Bayi / Balita (S)',
            'items' => $items,
        ]);
    }

    public function create()
    {
        return view('bayi_balita.form', [
            'title' => 'Tambah Jumlah Bayi / Balita',
            'item'  => null,
            'isEdit'=> false,
            'usiaOptions' => $this->usiaOptions,
            'formAction'  => route('bayi-balita.store'),
            'formMethod'  => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tahun'        => 'required|integer|min:2000|max:2100',
            'usia_kategori'=> 'required|string',
            'laki_laki'    => 'nullable|integer|min:0',
            'perempuan'    => 'nullable|integer|min:0',
        ]);

        // default 0 kalau kosong
        $data['laki_laki'] = $data['laki_laki'] ?? 0;
        $data['perempuan'] = $data['perempuan'] ?? 0;

        // Pastikan kategori sesuai opsi
        if (!in_array($data['usia_kategori'], $this->usiaOptions, true)) {
            return back()->withErrors(['usia_kategori' => 'Kategori usia tidak valid'])->withInput();
        }

        // optional: cegah dobel (tahun + kategori)
        $exists = JumlahBayiBalita::where('tahun', $data['tahun'])
            ->where('usia_kategori', $data['usia_kategori'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['usia_kategori' => 'Data untuk tahun & kategori ini sudah ada'])->withInput();
        }

        JumlahBayiBalita::create($data);

        return redirect()->route('bayi-balita.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(JumlahBayiBalita $bayi_balitum) // laravel bisa beda binding, kita aman pakai parameter manual di bawah
    {
        // biar tidak bingung binding, kita override: method ini tidak dipakai.
    }

    public function editById($id)
    {
        $item = JumlahBayiBalita::findOrFail($id);

        return view('bayi_balita.form', [
            'title' => 'Edit Jumlah Bayi / Balita',
            'item'  => $item,
            'isEdit'=> true,
            'usiaOptions' => $this->usiaOptions,
            'formAction'  => route('bayi-balita.update', $item->id),
            'formMethod'  => 'PUT',
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = JumlahBayiBalita::findOrFail($id);

        $data = $request->validate([
            'tahun'        => 'required|integer|min:2000|max:2100',
            'usia_kategori'=> 'required|string',
            'laki_laki'    => 'nullable|integer|min:0',
            'perempuan'    => 'nullable|integer|min:0',
        ]);

        $data['laki_laki'] = $data['laki_laki'] ?? 0;
        $data['perempuan'] = $data['perempuan'] ?? 0;

        if (!in_array($data['usia_kategori'], $this->usiaOptions, true)) {
            return back()->withErrors(['usia_kategori' => 'Kategori usia tidak valid'])->withInput();
        }

        // optional: cegah dobel (kecuali record sendiri)
        $exists = JumlahBayiBalita::where('tahun', $data['tahun'])
            ->where('usia_kategori', $data['usia_kategori'])
            ->where('id', '!=', $item->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['usia_kategori' => 'Data untuk tahun & kategori ini sudah ada'])->withInput();
        }

        $item->update($data);

        return redirect()->route('bayi-balita.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        $item = JumlahBayiBalita::findOrFail($id);
        $item->delete();

        return redirect()->route('bayi-balita.index')->with('success', 'Data berhasil dihapus.');
    }
}
