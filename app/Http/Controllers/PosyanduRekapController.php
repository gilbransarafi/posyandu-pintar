<?php

namespace App\Http\Controllers;

use App\Models\PosyanduRekap;
use Illuminate\Http\Request;

class PosyanduRekapController extends Controller
{
    /**
     * konfigurasi 32 item (sesuai kertas)
     * ini sama ide-nya seperti di DashboardController
     */
    private array $rekapConfig = [
        ['no' => 1,  'label' => 'Jumlah WUS / PUS', 'anchor' => 'item-1'],
        ['no' => 2,  'label' => 'Jumlah PUS ikut KB', 'anchor' => 'item-2'],
        ['no' => 3,  'label' => 'Jumlah peserta KB MKET (MOP/MOW/IUD/Implant)', 'anchor' => 'item-3'],
        ['no' => 4,  'label' => 'Jumlah peserta KB non MKET (Suntik/Pil/Kondom)', 'anchor' => 'item-4'],
        ['no' => 5,  'label' => 'Jumlah Ibu Hamil', 'anchor' => 'item-5'],
        ['no' => 6,  'label' => 'Jumlah Ibu Hamil yang mendapat tablet besi (FE)', 'anchor' => 'item-6'],
        ['no' => 7,  'label' => 'Jumlah Ibu Hamil risiko tinggi', 'anchor' => 'item-7'],
        ['no' => 8,  'label' => 'Jumlah Ibu Hamil risiko tinggi yang dirujuk', 'anchor' => 'item-8'],
        ['no' => 9,  'label' => 'Jumlah Ibu Hamil Anemia', 'anchor' => 'item-9'],
        ['no' => 10, 'label' => 'Jumlah Ibu Hamil KEK', 'anchor' => 'item-10'],
        ['no' => 11, 'label' => 'Jumlah Ibu Hamil dapat imunisasi TT I / TT II', 'anchor' => 'item-11'],
        ['no' => 12, 'label' => 'Jumlah Ibu Hamil meninggal (Kehamilan/Persalinan)', 'anchor' => 'item-12'],
        ['no' => 13, 'label' => 'Jumlah Ibu Nifas yang mendapat Vitamin A', 'anchor' => 'item-13'],
        ['no' => 14, 'label' => 'Jumlah Kelahiran', 'anchor' => 'item-14'],
        ['no' => 15, 'label' => 'Jumlah Kematian Bayi / Balita', 'anchor' => 'item-15'],
        [
            'no'    => 16,
            'label' => 'Jumlah Bayi / Balita (S)',
            'anchor'=> 'item-16',
            'has_gender' => true,
        ],
        ['no' => 17, 'label' => 'Jumlah Bayi / Balita yang memiliki KMS (K)', 'anchor' => 'item-17'],
        ['no' => 18, 'label' => 'Jumlah Bayi / Balita yang ditimbang (D)', 'anchor' => 'item-18'],
        ['no' => 19, 'label' => 'Hasil penimbangan sesuai Rambu Gizi', 'anchor' => 'item-19'],
        ['no' => 20, 'label' => 'Jumlah Balita Gizi Buruk (lama / baru)', 'anchor' => 'item-20'],
        ['no' => 21, 'label' => 'Balita Gizi Buruk yang mendapat Perawatan (lama / baru)', 'anchor' => 'item-21'],
        ['no' => 22, 'label' => 'Jumlah Balita Bawah Garis Merah (BGM) (lama / baru)', 'anchor' => 'item-22'],
        ['no' => 23, 'label' => 'Jumlah Balita yang tidak naik BB 2x berturut-turut', 'anchor' => 'item-23'],
        ['no' => 24, 'label' => 'Jumlah Bayi 6–24 bln Gakin mendapat MP-ASI', 'anchor' => 'item-24'],
        ['no' => 25, 'label' => 'Jumlah Bayi 6–11 bln mendapat kapsul Vit A', 'anchor' => 'item-25'],
        ['no' => 26, 'label' => 'Jumlah Bayi/Anak 12–59 bln mendapat kapsul Vit A', 'anchor' => 'item-26'],
        ['no' => 27, 'label' => 'Jumlah Balita yang mendapat PMT Pemulihan', 'anchor' => 'item-27'],
        ['no' => 28, 'label' => 'Jumlah Bayi yang mendapat imunisasi BCG', 'anchor' => 'item-28'],
        ['no' => 29, 'label' => 'Jumlah Bayi yang mendapat imunisasi Campak', 'anchor' => 'item-29'],
        ['no' => 30, 'label' => 'Jumlah Bayi yang mendapat imunisasi Polio', 'anchor' => 'item-30'],
        ['no' => 31, 'label' => 'Jumlah Bayi/Anak ASI Eksklusif', 'anchor' => 'item-31'],
        ['no' => 32, 'label' => 'Jumlah Bayi BBLR', 'anchor' => 'item-32'],
    ];

    /**
     * Halaman input rekap (tampilan seperti kertas, tapi versi web sederhana).
     */
    public function index(Request $request)
    {
        $year = (int) $request->input('year', now()->year);

        $rekapDb = PosyanduRekap::where('year', $year)->get()->keyBy('code');

        $rekapList = array_map(function (array $item) use ($rekapDb) {
            $code = $item['anchor'];

            $item['value']  = $rekapDb[$code]->value  ?? 0;
            $item['male']   = $rekapDb[$code]->male   ?? null;
            $item['female'] = $rekapDb[$code]->female ?? null;

            return $item;
        }, $this->rekapConfig);

        return view('rekap.index', [
            'selected_year' => $year,
            'rekap_list'    => $rekapList,
        ]);
    }

    /**
     * Simpan semua isian 1–32 ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year'            => 'required|integer|min:2000|max:2100',
            'rekap'           => 'required|array',
            'rekap.*.value'   => 'nullable|integer|min:0',
            'rekap.*.male'    => 'nullable|integer|min:0',
            'rekap.*.female'  => 'nullable|integer|min:0',
        ]);

        $year = $validated['year'];

        foreach ($this->rekapConfig as $item) {
            $code = $item['anchor'];

            $rowInput = $validated['rekap'][$code] ?? [];

            $value  = (int) ($rowInput['value'] ?? 0);
            $male   = isset($rowInput['male']) ? (int) $rowInput['male'] : null;
            $female = isset($rowInput['female']) ? (int) $rowInput['female'] : null;

            PosyanduRekap::updateOrCreate(
                [
                    'year' => $year,
                    'code' => $code,
                ],
                [
                    'value'  => $value,
                    'male'   => $male,
                    'female' => $female,
                ]
            );
        }

        return redirect()
            ->route('rekap.index', ['year' => $year])
            ->with('success', 'Rekap berhasil disimpan.');
    }
}
