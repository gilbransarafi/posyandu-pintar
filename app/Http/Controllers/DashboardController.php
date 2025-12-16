<?php

namespace App\Http\Controllers;

use App\Models\PosyanduRekap;
use App\Models\PosyanduStat;

use App\Models\JumlahWusPus;
use App\Models\JumlahPusKb;
use App\Models\JumlahKbMket;
use App\Models\JumlahKbNonMket;
use App\Models\JumlahIbuHamil;
use App\Models\IbuHamilTabletBesi;
use App\Models\IbuHamilMeninggal;
use App\Models\IbuHamilRisikoTinggi;
use App\Models\IbuHamilAnemia;
use App\Models\IbuHamilKek;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Kategori utama layanan posyandu
     */
    private array $categories = [
        'balita',
        'imunisasi',
        'ibu',
        'konsultasi',
    ];

    /**
     * Label singkat bulan (untuk chart)
     */
    private array $labels = [
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des',
    ];

    /**
     * Opsi bulan lengkap (untuk select input)
     */
    private array $monthOptions = [
        1 => 'Januari',  2 => 'Februari', 3 => 'Maret',    4 => 'April',
        5 => 'Mei',      6 => 'Juni',     7 => 'Juli',     8 => 'Agustus',
        9 => 'September',10 => 'Oktober', 11 => 'November',12 => 'Desember',
    ];

    /**
     * Label kategori untuk tampilan
     */
    private array $categoryLabels = [
        'balita'      => 'Penimbangan Balita',
        'imunisasi'   => 'Imunisasi Anak',
        'ibu'         => 'Pemeriksaan Ibu Hamil',
        'konsultasi'  => 'Konsultasi Kesehatan',
    ];

    /**
     * Konfigurasi dasar rekap (sebelum diisi dari DB)
     */
    private array $rekapConfig = [
        ['no' => 1,  'label' => 'Jumlah WUS / PUS', 'anchor' => 'item-1',  'value' => 0],
        ['no' => 2,  'label' => 'Jumlah PUS ikut KB', 'anchor' => 'item-2',  'value' => 0],
        ['no' => 3,  'label' => 'Jumlah peserta KB MKET (MOP/MOW/IUD/Implant)', 'anchor' => 'item-3',  'value' => 0],
        ['no' => 4,  'label' => 'Jumlah peserta KB non MKET (Suntik/Pil/Kondom)', 'anchor' => 'item-4',  'value' => 0],
        ['no' => 5,  'label' => 'Jumlah Ibu Hamil', 'anchor' => 'item-5',  'value' => 0],
        ['no' => 6,  'label' => 'Ibu Hamil dapat tablet besi (FE)', 'anchor' => 'item-6',  'value' => 0],
        ['no' => 7,  'label' => 'Ibu Hamil risiko tinggi', 'anchor' => 'item-7',  'value' => 0],
        ['no' => 8,  'label' => 'Ibu Hamil risiko tinggi yang dirujuk', 'anchor' => 'item-8',  'value' => 0],
        ['no' => 9,  'label' => 'Ibu Hamil Anemia', 'anchor' => 'item-9',  'value' => 0],
        ['no' => 10, 'label' => 'Ibu Hamil KEK', 'anchor' => 'item-10', 'value' => 0],
        ['no' => 11, 'label' => 'Ibu Hamil dapat imunisasi TT I / TT II', 'anchor' => 'item-11', 'value' => 0],
        ['no' => 12, 'label' => 'Ibu Hamil meninggal (kehamilan/persalinan)', 'anchor' => 'item-12', 'value' => 0],
        ['no' => 13, 'label' => 'Ibu Nifas mendapat Vitamin A', 'anchor' => 'item-13', 'value' => 0],
        ['no' => 14, 'label' => 'Jumlah Kelahiran', 'anchor' => 'item-14', 'value' => 0],
        ['no' => 15, 'label' => 'Jumlah Kematian Bayi / Balita', 'anchor' => 'item-15', 'value' => 0],
        [
            'no'         => 16,
            'label'      => 'Jumlah Bayi / Balita (S)',
            'anchor'     => 'item-16',
            'value'      => 0,
            'has_gender' => true,
            'male'       => 0,
            'female'     => 0,
        ],
        ['no' => 17, 'label' => 'Bayi / Balita memiliki KMS (K)', 'anchor' => 'item-17', 'value' => 0],
        ['no' => 18, 'label' => 'Bayi / Balita ditimbang (D)', 'anchor' => 'item-18', 'value' => 0],
        ['no' => 19, 'label' => 'Hasil penimbangan sesuai rambu gizi', 'anchor' => 'item-19', 'value' => 0],
        ['no' => 20, 'label' => 'Balita gizi buruk (lama / baru)', 'anchor' => 'item-20', 'value' => 0],
        ['no' => 21, 'label' => 'Balita gizi buruk dapat perawatan (lama / baru)', 'anchor' => 'item-21', 'value' => 0],
        ['no' => 22, 'label' => 'Balita bawah garis merah (BGM) (lama / baru)', 'anchor' => 'item-22', 'value' => 0],
        ['no' => 23, 'label' => 'Balita tidak naik BB 2x', 'anchor' => 'item-23', 'value' => 0],
        ['no' => 24, 'label' => 'Bayi 6-24 bln Gakin dapat MP-ASI', 'anchor' => 'item-24', 'value' => 0],
        ['no' => 25, 'label' => 'Bayi 6-24 bln dapat kapsul Vit A (6-11 bln)', 'anchor' => 'item-25', 'value' => 0],
        ['no' => 26, 'label' => 'Bayi/Anak dapat kapsul Vit A (12-59 bln)', 'anchor' => 'item-26', 'value' => 0],
        ['no' => 27, 'label' => 'Balita dapat PMT Pemulihan', 'anchor' => 'item-27', 'value' => 0],
        ['no' => 28, 'label' => 'Bayi mendapat imunisasi BCG', 'anchor' => 'item-28', 'value' => 0],
        ['no' => 29, 'label' => 'Bayi mendapat imunisasi Campak', 'anchor' => 'item-29', 'value' => 0],
        ['no' => 30, 'label' => 'Bayi mendapat imunisasi Polio', 'anchor' => 'item-30', 'value' => 0],
        ['no' => 31, 'label' => 'Bayi/Anak ASI eksklusif', 'anchor' => 'item-31', 'value' => 0],
        ['no' => 32, 'label' => 'Bayi BBLR', 'anchor' => 'item-32', 'value' => 0],
    ];

    public function index(Request $request)
    {
        $requestedYear = $request->input('year');

        // Tahun yang tersedia dari berbagai tabel indikator utama
        $availableYears = $this->getAvailableYearsFromSources();

        // Jika tidak ada input tahun, pakai tahun terbaru yang tersedia, fallback ke tahun sekarang
        $year = $requestedYear !== null
            ? (int) $requestedYear
            : (count($availableYears) ? (int) ($availableYears[0]) : (int) now()->year);

        // Data utama grafik & total per kategori
        [$chartData, $totals] = $this->buildChartData($year);

        // Rekap isian form (32 item)
        $rekapList = $this->buildRekapList($year);
        [$rekapBasic, $rekapBayi, $rekapBasicChart, $rekapBayiChart] = $this->buildRekapCharts($rekapList);

        // Layanan terbaru per kategori
        $latestServices = $this->buildLatestServices($chartData, $this->labels);

        // Ringkasan progress input
        [$sumAll, $needInput, $filledCategories, $inputCoverage] = $this->buildSummaryMetrics($chartData);

        // Tahun yang tersedia di database
        // Pastikan tahun terpilih masuk ke daftar dropdown
        if (! in_array($year, $availableYears, true)) {
            $availableYears[] = $year;
            rsort($availableYears);
        }

        // 5 indikator utama (gender)
        $topGender = $this->buildTopGenderIndicators($year);
        $totalPeserta = collect($topGender)->sum('total');

        return view('dashboard', [
            'labels'            => $this->labels,
            'balita'            => $chartData['balita'],
            'imunisasi'         => $chartData['imunisasi'],
            'ibu'               => $chartData['ibu'],
            'konsultasi'        => $chartData['konsultasi'],

            'total_balita'      => $totals['balita'] ?? 0,
            'total_imunisasi'   => $totals['imunisasi'] ?? 0,
            'total_ibu'         => $totals['ibu'] ?? 0,
            'total_konsultasi'  => $totals['konsultasi'] ?? 0,

            'selected_year'     => $year,
            'available_years'   => $availableYears,
            'categories'        => $this->categories,

            'rekap_list'        => $rekapList,
            'rekap_basic'       => $rekapBasic,
            'rekap_bayi'        => $rekapBayi,
            'rekap_basic_chart' => $rekapBasicChart,
            'rekap_bayi_chart'  => $rekapBayiChart,

            'latest_services'   => $latestServices,
            'month_options'     => $this->monthOptions,

            'sum_all'           => $sumAll,
            'need_input'        => $needInput,
            'filled_categories' => $filledCategories,
            'input_coverage'    => $inputCoverage,

            'category_labels'   => $this->categoryLabels,
            'top_rekap'         => array_slice($rekapList, 0, 5),

            'top_gender'        => $topGender,
            'total_peserta'     => $totalPeserta,
            'totalTabletBesi'   => IbuHamilTabletBesi::where('tahun', $year)->sum(\DB::raw('fe1 + fe3')),
            'totalIbuMeninggal' => (function () use ($year) {
                $val = IbuHamilMeninggal::where('tahun', $year)->sum('jumlah');
                return $val > 0 ? $val : IbuHamilMeninggal::sum('jumlah');
            })(),
            'totalIbuAnemia'    => (function () use ($year) {
                $val = IbuHamilAnemia::where('tahun', $year)->sum('jumlah');
                return $val > 0 ? $val : IbuHamilAnemia::sum('jumlah');
            })(),
            'totalIbuKek'       => (function () use ($year) {
                $val = IbuHamilKek::where('tahun', $year)->sum('jumlah');
                return $val > 0 ? $val : IbuHamilKek::sum('jumlah');
            })(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:balita,imunisasi,ibu,konsultasi',
            'month'    => 'required|integer|min:1|max:12',
            'year'     => 'required|integer|min:2000|max:2100',
            'value'    => 'required|integer|min:0',
        ]);

        PosyanduStat::updateOrCreate(
            [
                'category' => $validated['category'],
                'month'    => $validated['month'],
                'year'     => $validated['year'],
            ],
            [
                'value'    => $validated['value'],
            ]
        );

        return redirect()
            ->route('dashboard', ['year' => $validated['year']])
            ->with('success', 'Data berhasil disimpan/diupdate.');
    }

    // =========================
    // Helper Functions
    // =========================

    private function buildChartData(int $year): array
    {
        $baseMonths = array_fill(1, 12, 0);

        $stats = PosyanduStat::where('year', $year)
            ->get()
            ->groupBy('category');

        $chartData = [];
        foreach ($this->categories as $category) {
            $data = $baseMonths;
            if (isset($stats[$category])) {
                foreach ($stats[$category] as $row) {
                    $data[$row->month] = $row->value;
                }
            }
            $chartData[$category] = array_values($data);
        }

        $totals = PosyanduStat::selectRaw('category, SUM(value) as total')
            ->where('year', $year)
            ->groupBy('category')
            ->pluck('total', 'category');

        return [$chartData, $totals];
    }

    private function buildRekapList(int $year): array
    {
        $rekapDb = PosyanduRekap::where('year', $year)
            ->get()
            ->keyBy('code');

        $rekapList = $this->rekapConfig;

        $rekapList = array_map(function (array $item) use ($rekapDb) {
            $code = $item['anchor'];

            if (isset($rekapDb[$code])) {
                $rekap = $rekapDb[$code];
                $item['value']      = $rekap->value;
                $item['rekap_id']   = $rekap->id;
                $item['updated_at'] = optional($rekap->updated_at)->format('Y-m-d');
            }

            return $item;
        }, $rekapList);

        return $rekapList;
    }

    private function buildRekapCharts(array $rekapList): array
    {
        $rekapBasic = array_slice($rekapList, 0, 15);
        $rekapBayi  = array_slice($rekapList, 15);

        $rekapBasicChart = array_map(static function ($row) {
            return [
                'label' => $row['label'],
                'value' => $row['value'] ?? 0,
            ];
        }, $rekapBasic);

        $rekapBayiChart = array_map(static function ($row) {
            return [
                'label'      => $row['label'],
                'value'      => $row['value'] ?? 0,
                'male'       => $row['male'] ?? 0,
                'female'     => $row['female'] ?? 0,
                'has_gender' => $row['has_gender'] ?? false,
            ];
        }, $rekapBayi);

        return [$rekapBasic, $rekapBayi, $rekapBasicChart, $rekapBayiChart];
    }

    private function buildLatestServices(array $chartData, array $labels): array
    {
        $latestServices = [];

        foreach ($this->categories as $category) {
            $data = $chartData[$category] ?? array_fill(0, 12, 0);

            $lastIndex = null;
            foreach (array_reverse($data, true) as $idx => $val) {
                if ($val > 0) {
                    $lastIndex = $idx;
                    break;
                }
            }

            if ($lastIndex === null) {
                $lastIndex = 11; // default Desember
            }

            $monthNumber = $lastIndex + 1;

            $latestServices[] = [
                'kategori_key' => $category,
                'kategori'     => $this->categoryLabels[$category] ?? ucfirst($category),
                'bulan'        => $labels[$monthNumber - 1] ?? '-',
                'jumlah'       => $data[$monthNumber - 1] ?? 0,
                'status'       => ($data[$monthNumber - 1] ?? 0) > 0
                    ? 'Selesai'
                    : 'Belum ada data',
            ];
        }

        return $latestServices;
    }

    private function buildSummaryMetrics(array $chartData): array
    {
        $sumAll = 0;
        foreach ($this->categories as $category) {
            $sumAll += array_sum($chartData[$category] ?? []);
        }

        $needInput = collect($chartData)
            ->filter(static fn ($arr) => array_sum($arr) === 0)
            ->count();

        $filledCategories = max(count($this->categories) - $needInput, 0);

        $inputCoverage = count($this->categories) > 0
            ? (int) round(($filledCategories / count($this->categories)) * 100)
            : 0;

        return [$sumAll, $needInput, $filledCategories, $inputCoverage];
    }

    /**
     * Tahun yang tersedia digabung dari beberapa sumber indikator utama.
     */
    private function getAvailableYearsFromSources(): array
    {
        $sources = [
            PosyanduStat::select('year'),
            JumlahWusPus::select('year'),
            JumlahPusKb::select('year'),
            JumlahKbMket::select('year'),
            JumlahKbNonMket::select('year'),
            JumlahIbuHamil::select('year'),
            IbuHamilTabletBesi::select('tahun as year'),
            IbuHamilRisikoTinggi::select('tahun as year'),
            IbuHamilAnemia::select('tahun as year'),
            IbuHamilKek::select('tahun as year'),
            IbuHamilMeninggal::select('tahun as year'),
        ];

        $years = [];
        foreach ($sources as $query) {
            $years = array_merge($years, $query->distinct()->pluck('year')->toArray());
        }

        $years = array_values(array_unique(array_map('intval', $years)));
        rsort($years);

        return $years;
    }

    /**
     * 5 indikator utama dengan pecahan laki-laki & perempuan
     * diambil dari 5 tabel khusus.
     */
    private function buildTopGenderIndicators(int $year): array
    {
        $config = [
            [
                'no'     => 1,
                'label'  => 'Jumlah WUS / PUS',
                'anchor' => 'item-1',
                'model'  => JumlahWusPus::class,
            ],
            [
                'no'     => 2,
                'label'  => 'Jumlah PUS ikut KB',
                'anchor' => 'item-2',
                'model'  => JumlahPusKb::class,
            ],
            [
                'no'     => 3,
                'label'  => 'Jumlah peserta KB MKET (MOP/MOW/IUD/Implant)',
                'anchor' => 'item-3',
                'model'  => JumlahKbMket::class,
            ],
            [
                'no'     => 4,
                'label'  => 'Jumlah peserta KB non MKET (Suntik/Pil/Kondom)',
                'anchor' => 'item-4',
                'model'  => JumlahKbNonMket::class,
            ],
            [
                'no'     => 5,
                'label'  => 'Jumlah Ibu Hamil',
                'anchor' => 'item-5',
                'model'  => JumlahIbuHamil::class,
            ],
            [
                'no'     => 6,
                'label'  => 'Ibu Hamil mendapat Tablet Besi (FE I / FE III)',
                'anchor' => 'item-6',
                'model'  => IbuHamilTabletBesi::class,
            ],
            [
                'no'     => 7,
                'label'  => 'Jumlah Ibu Hamil Meninggal',
                'anchor' => 'item-7',
                'model'  => IbuHamilMeninggal::class,
            ],
            [
                'no'     => 8,
                'label'  => 'Ibu Hamil Risiko Tinggi',
                'anchor' => 'item-8',
                'model'  => IbuHamilRisikoTinggi::class,
            ],
            [
                'no'     => 9,
                'label'  => 'Jumlah Ibu Hamil Anemia',
                'anchor' => 'item-9',
                'model'  => IbuHamilAnemia::class,
            ],
            [
                'no'     => 10,
                'label'  => 'Jumlah Ibu Hamil KEK',
                'anchor' => 'item-10',
                'model'  => IbuHamilKek::class,
            ],
        ];

        $result = [];

        foreach ($config as $row) {
            $male = 0;
            $female = 0;
            $total = 0;

            if ($row['model'] === JumlahWusPus::class) {
                // WUS/PUS sekarang diinput per bulan tanpa pecahan gender.
                $hasJumlahColumn = Schema::hasColumn('jumlah_wus_pus', 'jumlah');

                if ($hasJumlahColumn) {
                    $total = JumlahWusPus::where('year', $year)->sum('jumlah');
                }

                // Fallback ke kolom lama jika data belum menggunakan format baru.
                if (! $hasJumlahColumn || $total <= 0) {
                    $record = JumlahWusPus::where('year', $year)->first();
                    $male   = $record->male   ?? 0;
                    $female = $record->female ?? 0;
                    $total  = $male + $female;
                } else {
                    $female = $total;
                }
            } elseif ($row['model'] === JumlahPusKb::class) {
                $hasJumlahColumn = Schema::hasColumn('jumlah_pus_kb', 'jumlah');

                if ($hasJumlahColumn) {
                    $total = JumlahPusKb::where('year', $year)->sum('jumlah');
                }

                if (! $hasJumlahColumn || $total <= 0) {
                    $record = JumlahPusKb::where('year', $year)->first();
                    $male   = $record->male   ?? 0;
                    $female = $record->female ?? 0;
                    $total  = $male + $female;
                } else {
                    $female = $total;
                }
            } elseif ($row['model'] === JumlahKbMket::class) {
                $hasJumlahColumn = Schema::hasColumn('jumlah_kb_mket', 'jumlah');

                if ($hasJumlahColumn) {
                    // Total per tahun terpilih (otomatis naik/turun saat tambah/hapus)
                    $total = JumlahKbMket::where('year', $year)->sum('jumlah');
                }

                if (! $hasJumlahColumn || $total <= 0) {
                    $record = JumlahKbMket::where('year', $year)->first();
                    $male   = $record->male   ?? 0;
                    $female = $record->female ?? 0;
                    $total  = $male + $female;
                } else {
                    $female = $total;
                }
            } elseif ($row['model'] === JumlahKbNonMket::class) {
                $hasJumlahColumn = Schema::hasColumn('jumlah_kb_non_mket', 'jumlah');

                if ($hasJumlahColumn) {
                    $total = JumlahKbNonMket::where('year', $year)->sum('jumlah');
                }

                if (! $hasJumlahColumn || $total <= 0) {
                    $record = JumlahKbNonMket::where('year', $year)->first();
                    $male   = $record->male   ?? 0;
                    $female = $record->female ?? 0;
                    $total  = $male + $female;
                } else {
                    $female = $total;
                }
            } elseif ($row['model'] === JumlahIbuHamil::class) {
                $hasJumlahColumn = Schema::hasColumn('jumlah_ibu_hamil', 'jumlah');

                if ($hasJumlahColumn) {
                    $total = JumlahIbuHamil::where('year', $year)->sum('jumlah');
                }

                if (! $hasJumlahColumn || $total <= 0) {
                    $record = JumlahIbuHamil::where('year', $year)->first();
                    $male   = $record->male   ?? 0;
                    $female = $record->female ?? 0;
                    $total  = $male + $female;
                } else {
                    $female = $total;
                }
            } elseif ($row['model'] === IbuHamilTabletBesi::class) {
                $total = IbuHamilTabletBesi::where('tahun', $year)
                    ->sum(\DB::raw('fe1 + fe3'));
                $female = $total;
            } elseif ($row['model'] === IbuHamilMeninggal::class) {
                $total = IbuHamilMeninggal::where('tahun', $year)->sum('jumlah');
                if ($total <= 0) {
                    // fallback jika tahun terpilih belum ada data
                    $total = IbuHamilMeninggal::sum('jumlah');
                }
                $female = $total;
            } elseif ($row['model'] === IbuHamilRisikoTinggi::class) {
                $total = IbuHamilRisikoTinggi::where('tahun', $year)->sum('jumlah');
                if ($total <= 0) {
                    $total = IbuHamilRisikoTinggi::sum('jumlah');
                }
                $female = $total;
            } elseif ($row['model'] === IbuHamilAnemia::class) {
                $total = IbuHamilAnemia::where('tahun', $year)->sum('jumlah');
                if ($total <= 0) {
                    $total = IbuHamilAnemia::sum('jumlah');
                }
                $female = $total;
            } elseif ($row['model'] === IbuHamilKek::class) {
                $total = IbuHamilKek::where('tahun', $year)->sum('jumlah');
                if ($total <= 0) {
                    $total = IbuHamilKek::sum('jumlah');
                }
                $female = $total;
            } else {
                $record = ($row['model'])::where('year', $year)->first();
                $male   = $record->male   ?? 0;
                $female = $record->female ?? 0;
                $total  = $male + $female;
            }

            $result[] = [
                'no'         => $row['no'],
                'label'      => $row['label'],
                'anchor'     => $row['anchor'],
                'male'       => $male,
                'female'     => $female,
                'total'      => $total,
            ];
        }

        return $result;
    }
}
