<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JumlahIbuHamilController;
use App\Http\Controllers\JumlahKbMketController;
use App\Http\Controllers\JumlahKbNonMketController;
use App\Http\Controllers\JumlahPusKbController;
use App\Http\Controllers\JumlahWusPusController;
use App\Http\Controllers\JumlahBayiBalitaController; // ✅
use App\Http\Controllers\IbuHamilTabletBesiController; // ✅ (FE I / FE III)
use App\Http\Controllers\IbuHamilMeninggalController; // ✅
use App\Http\Controllers\IbuHamilRisikoTinggiController; // ✅ (Risiko Tinggi)
use App\Http\Controllers\IbuHamilAnemiaController; // ✅ (Anemia)
use App\Http\Controllers\IbuHamilKekController; // ✅ TAMBAH INI (KEK)
use App\Http\Controllers\PosyanduRekapController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED AREA (ADMIN / KADER)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/dashboard/stat', [DashboardController::class, 'store'])
        ->name('dashboard.store');

    /*
    |--------------------------------------------------------------------------
    | REKAP POSYANDU (32 INDIKATOR)
    |--------------------------------------------------------------------------
    */
    Route::prefix('rekap')->name('rekap.')->group(function () {

        Route::get('/', [PosyanduRekapController::class, 'index'])
            ->name('index');

        Route::post('/', [PosyanduRekapController::class, 'store'])
            ->name('store');

        Route::put('/{rekap}', [PosyanduRekapController::class, 'update'])
            ->name('update');

        Route::delete('/{rekap}', [PosyanduRekapController::class, 'destroy'])
            ->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | INDIKATOR UTAMA (CRUD TERPISAH)
    |--------------------------------------------------------------------------
    */
    Route::prefix('indikator')->name('indikator.')->group(function () {

        Route::resource('wus-pus', JumlahWusPusController::class);
        Route::resource('pus-kb', JumlahPusKbController::class);
        Route::resource('kb-mket', JumlahKbMketController::class);
        Route::resource('kb-non-mket', JumlahKbNonMketController::class);
        Route::resource('ibu-hamil', JumlahIbuHamilController::class);

        Route::resource('bayi-balita', JumlahBayiBalitaController::class); // ✅
        Route::resource('ibu-hamil-tablet-besi', IbuHamilTabletBesiController::class); // ✅ FE
        Route::resource('ibu-hamil-meninggal', IbuHamilMeninggalController::class); // ✅

        // ✅ Risiko Tinggi
        Route::resource('ibu-hamil-risiko-tinggi', IbuHamilRisikoTinggiController::class);

        // ✅ Anemia
        Route::resource('ibu-hamil-anemia', IbuHamilAnemiaController::class);

        // ✅ TAMBAH INI: KEK
        Route::resource('ibu-hamil-kek', IbuHamilKekController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | ROUTE ALIAS (BIAR SIDEBAR / MENU PASTI NYAMBUNG)
    |--------------------------------------------------------------------------
    */

    // ✅ Alias index Anemia & Risiko Tinggi
    Route::get('/ibu-hamil-anemia', [IbuHamilAnemiaController::class, 'index'])
        ->name('ibu-hamil-anemia.index');

    Route::get('/ibu-hamil-risiko-tinggi', [IbuHamilRisikoTinggiController::class, 'index'])
        ->name('ibu-hamil-risiko-tinggi.index');

    // ✅ TAMBAH INI: Alias index KEK
    Route::get('/ibu-hamil-kek', [IbuHamilKekController::class, 'index'])
        ->name('ibu-hamil-kek.index');

    // Alias CRUD Ibu Hamil Risiko Tinggi (tanpa prefix indikator) supaya link di view berjalan
    Route::get('/ibu-hamil-risiko-tinggi/create', [IbuHamilRisikoTinggiController::class, 'create'])
        ->name('ibu-hamil-risiko-tinggi.create');
    Route::post('/ibu-hamil-risiko-tinggi', [IbuHamilRisikoTinggiController::class, 'store'])
        ->name('ibu-hamil-risiko-tinggi.store');
    Route::get('/ibu-hamil-risiko-tinggi/{ibu_hamil_risiko_tinggi}/edit', [IbuHamilRisikoTinggiController::class, 'edit'])
        ->name('ibu-hamil-risiko-tinggi.edit');
    Route::put('/ibu-hamil-risiko-tinggi/{ibu_hamil_risiko_tinggi}', [IbuHamilRisikoTinggiController::class, 'update'])
        ->name('ibu-hamil-risiko-tinggi.update');
    Route::delete('/ibu-hamil-risiko-tinggi/{ibu_hamil_risiko_tinggi}', [IbuHamilRisikoTinggiController::class, 'destroy'])
        ->name('ibu-hamil-risiko-tinggi.destroy');

    // Alias CRUD Ibu Hamil Anemia (tanpa prefix indikator) supaya link di view berjalan
    Route::get('/ibu-hamil-anemia/create', [IbuHamilAnemiaController::class, 'create'])
        ->name('ibu-hamil-anemia.create');
    Route::post('/ibu-hamil-anemia', [IbuHamilAnemiaController::class, 'store'])
        ->name('ibu-hamil-anemia.store');
    Route::get('/ibu-hamil-anemia/{ibu_hamil_anemia}/edit', [IbuHamilAnemiaController::class, 'edit'])
        ->name('ibu-hamil-anemia.edit');
    Route::put('/ibu-hamil-anemia/{ibu_hamil_anemia}', [IbuHamilAnemiaController::class, 'update'])
        ->name('ibu-hamil-anemia.update');
    Route::delete('/ibu-hamil-anemia/{ibu_hamil_anemia}', [IbuHamilAnemiaController::class, 'destroy'])
        ->name('ibu-hamil-anemia.destroy');

    // ✅ TAMBAH INI: Alias CRUD Ibu Hamil KEK (tanpa prefix indikator) supaya link di view berjalan
    Route::get('/ibu-hamil-kek/create', [IbuHamilKekController::class, 'create'])
        ->name('ibu-hamil-kek.create');
    Route::post('/ibu-hamil-kek', [IbuHamilKekController::class, 'store'])
        ->name('ibu-hamil-kek.store');
    Route::get('/ibu-hamil-kek/{ibu_hamil_kek}/edit', [IbuHamilKekController::class, 'edit'])
        ->name('ibu-hamil-kek.edit');
    Route::put('/ibu-hamil-kek/{ibu_hamil_kek}', [IbuHamilKekController::class, 'update'])
        ->name('ibu-hamil-kek.update');
    Route::delete('/ibu-hamil-kek/{ibu_hamil_kek}', [IbuHamilKekController::class, 'destroy'])
        ->name('ibu-hamil-kek.destroy');

    /*
    |--------------------------------------------------------------------------
    | ROUTES TANPA PREFIX (akses langsung) - YANG SUDAH ADA
    |--------------------------------------------------------------------------
    | Aku biarkan route manual yang lama (wus/pus/kb/ibu hamil/bayi dll)
    | Karena kamu sudah pakai itu sebelumnya.
    */

    // WUS / PUS
    Route::get('/wus-pus', [JumlahWusPusController::class, 'index'])->name('wus-pus.index');
    Route::get('/wus-pus/create', [JumlahWusPusController::class, 'create'])->name('wus-pus.create');
    Route::post('/wus-pus', [JumlahWusPusController::class, 'store'])->name('wus-pus.store');
    Route::get('/wus-pus/{wus_pus}/edit', [JumlahWusPusController::class, 'edit'])->name('wus-pus.edit');
    Route::put('/wus-pus/{wus_pus}', [JumlahWusPusController::class, 'update'])->name('wus-pus.update');
    Route::delete('/wus-pus/{wus_pus}', [JumlahWusPusController::class, 'destroy'])->name('wus-pus.destroy');

    // PUS KB
    Route::get('/pus-kb', [JumlahPusKbController::class, 'index'])->name('pus-kb.index');
    Route::get('/pus-kb/create', [JumlahPusKbController::class, 'create'])->name('pus-kb.create');
    Route::post('/pus-kb', [JumlahPusKbController::class, 'store'])->name('pus-kb.store');
    Route::get('/pus-kb/{pus_kb}/edit', [JumlahPusKbController::class, 'edit'])->name('pus-kb.edit');
    Route::put('/pus-kb/{pus_kb}', [JumlahPusKbController::class, 'update'])->name('pus-kb.update');
    Route::delete('/pus-kb/{pus_kb}', [JumlahPusKbController::class, 'destroy'])->name('pus-kb.destroy');

    // KB MKET
    Route::get('/kb-mket', [JumlahKbMketController::class, 'index'])->name('kb-mket.index');
    Route::get('/kb-mket/create', [JumlahKbMketController::class, 'create'])->name('kb-mket.create');
    Route::post('/kb-mket', [JumlahKbMketController::class, 'store'])->name('kb-mket.store');
    Route::get('/kb-mket/{kb_mket}/edit', [JumlahKbMketController::class, 'edit'])->name('kb-mket.edit');
    Route::put('/kb-mket/{kb_mket}', [JumlahKbMketController::class, 'update'])->name('kb-mket.update');
    Route::delete('/kb-mket/{kb_mket}', [JumlahKbMketController::class, 'destroy'])->name('kb-mket.destroy');

    // KB NON MKET
    Route::get('/kb-non-mket', [JumlahKbNonMketController::class, 'index'])->name('kb-non-mket.index');
    Route::get('/kb-non-mket/create', [JumlahKbNonMketController::class, 'create'])->name('kb-non-mket.create');
    Route::post('/kb-non-mket', [JumlahKbNonMketController::class, 'store'])->name('kb-non-mket.store');
    Route::get('/kb-non-mket/{kb_non_mket}/edit', [JumlahKbNonMketController::class, 'edit'])->name('kb-non-mket.edit');
    Route::put('/kb-non-mket/{kb_non_mket}', [JumlahKbNonMketController::class, 'update'])->name('kb-non-mket.update');
    Route::delete('/kb-non-mket/{kb_non_mket}', [JumlahKbNonMketController::class, 'destroy'])->name('kb-non-mket.destroy');

    // IBU HAMIL
    Route::get('/ibu-hamil', [JumlahIbuHamilController::class, 'index'])->name('ibu-hamil.index');
    Route::get('/ibu-hamil/create', [JumlahIbuHamilController::class, 'create'])->name('ibu-hamil.create');
    Route::post('/ibu-hamil', [JumlahIbuHamilController::class, 'store'])->name('ibu-hamil.store');
    Route::get('/ibu-hamil/{ibu_hamil}/edit', [JumlahIbuHamilController::class, 'edit'])->name('ibu-hamil.edit');
    Route::put('/ibu-hamil/{ibu_hamil}', [JumlahIbuHamilController::class, 'update'])->name('ibu-hamil.update');
    Route::delete('/ibu-hamil/{ibu_hamil}', [JumlahIbuHamilController::class, 'destroy'])->name('ibu-hamil.destroy');

    // BAYI / BALITA
    Route::get('/bayi-balita', [JumlahBayiBalitaController::class, 'index'])->name('bayi-balita.index');
    Route::get('/bayi-balita/create', [JumlahBayiBalitaController::class, 'create'])->name('bayi-balita.create');
    Route::post('/bayi-balita', [JumlahBayiBalitaController::class, 'store'])->name('bayi-balita.store');
    Route::get('/bayi-balita/{bayi_balita}/edit', [JumlahBayiBalitaController::class, 'edit'])->name('bayi-balita.edit');
    Route::put('/bayi-balita/{bayi_balita}', [JumlahBayiBalitaController::class, 'update'])->name('bayi-balita.update');
    Route::delete('/bayi-balita/{bayi_balita}', [JumlahBayiBalitaController::class, 'destroy'])->name('bayi-balita.destroy');

    // IBU HAMIL TABLET BESI (FE I / FE III)
    Route::get('/ibu-hamil-tablet-besi', [IbuHamilTabletBesiController::class, 'index'])->name('ibu-hamil-tablet-besi.index');
    Route::get('/ibu-hamil-tablet-besi/create', [IbuHamilTabletBesiController::class, 'create'])->name('ibu-hamil-tablet-besi.create');
    Route::post('/ibu-hamil-tablet-besi', [IbuHamilTabletBesiController::class, 'store'])->name('ibu-hamil-tablet-besi.store');
    Route::get('/ibu-hamil-tablet-besi/{ibu_hamil_tablet_besi}/edit', [IbuHamilTabletBesiController::class, 'edit'])->name('ibu-hamil-tablet-besi.edit');
    Route::put('/ibu-hamil-tablet-besi/{ibu_hamil_tablet_besi}', [IbuHamilTabletBesiController::class, 'update'])->name('ibu-hamil-tablet-besi.update');
    Route::delete('/ibu-hamil-tablet-besi/{ibu_hamil_tablet_besi}', [IbuHamilTabletBesiController::class, 'destroy'])->name('ibu-hamil-tablet-besi.destroy');

    // IBU HAMIL MENINGGAL
    Route::get('/ibu-hamil-meninggal', [IbuHamilMeninggalController::class, 'index'])->name('ibu-hamil-meninggal.index');
    Route::get('/ibu-hamil-meninggal/create', [IbuHamilMeninggalController::class, 'create'])->name('ibu-hamil-meninggal.create');
    Route::post('/ibu-hamil-meninggal', [IbuHamilMeninggalController::class, 'store'])->name('ibu-hamil-meninggal.store');
    Route::get('/ibu-hamil-meninggal/{ibu_hamil_meninggal}/edit', [IbuHamilMeninggalController::class, 'edit'])->name('ibu-hamil-meninggal.edit');
    Route::put('/ibu-hamil-meninggal/{ibu_hamil_meninggal}', [IbuHamilMeninggalController::class, 'update'])->name('ibu-hamil-meninggal.update');
    Route::delete('/ibu-hamil-meninggal/{ibu_hamil_meninggal}', [IbuHamilMeninggalController::class, 'destroy'])->name('ibu-hamil-meninggal.destroy');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
