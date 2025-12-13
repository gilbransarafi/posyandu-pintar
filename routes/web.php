<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JumlahIbuHamilController;
use App\Http\Controllers\JumlahKbMketController;
use App\Http\Controllers\JumlahKbNonMketController;
use App\Http\Controllers\JumlahPusKbController;
use App\Http\Controllers\JumlahWusPusController;
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
    | Dipakai untuk menu sidebar & dashboard
    */
    Route::prefix('indikator')->name('indikator.')->group(function () {

        Route::resource('wus-pus', JumlahWusPusController::class);
        Route::resource('pus-kb', JumlahPusKbController::class);
        Route::resource('kb-mket', JumlahKbMketController::class);
        Route::resource('kb-non-mket', JumlahKbNonMketController::class);
        Route::resource('ibu-hamil', JumlahIbuHamilController::class);

    });

    // Routes tanpa prefix untuk kemudahan akses di dashboard
    Route::get('/wus-pus', [JumlahWusPusController::class, 'index'])->name('wus-pus.index');
    Route::get('/wus-pus/create', [JumlahWusPusController::class, 'create'])->name('wus-pus.create');
    Route::post('/wus-pus', [JumlahWusPusController::class, 'store'])->name('wus-pus.store');
    Route::get('/wus-pus/{wus_pus}/edit', [JumlahWusPusController::class, 'edit'])->name('wus-pus.edit');
    Route::put('/wus-pus/{wus_pus}', [JumlahWusPusController::class, 'update'])->name('wus-pus.update');
    Route::delete('/wus-pus/{wus_pus}', [JumlahWusPusController::class, 'destroy'])->name('wus-pus.destroy');

    Route::get('/pus-kb', [JumlahPusKbController::class, 'index'])->name('pus-kb.index');
    Route::get('/pus-kb/create', [JumlahPusKbController::class, 'create'])->name('pus-kb.create');
    Route::post('/pus-kb', [JumlahPusKbController::class, 'store'])->name('pus-kb.store');
    Route::get('/pus-kb/{pus_kb}/edit', [JumlahPusKbController::class, 'edit'])->name('pus-kb.edit');
    Route::put('/pus-kb/{pus_kb}', [JumlahPusKbController::class, 'update'])->name('pus-kb.update');
    Route::delete('/pus-kb/{pus_kb}', [JumlahPusKbController::class, 'destroy'])->name('pus-kb.destroy');

    Route::get('/kb-mket', [JumlahKbMketController::class, 'index'])->name('kb-mket.index');
    Route::get('/kb-mket/create', [JumlahKbMketController::class, 'create'])->name('kb-mket.create');
    Route::post('/kb-mket', [JumlahKbMketController::class, 'store'])->name('kb-mket.store');
    Route::get('/kb-mket/{kb_mket}/edit', [JumlahKbMketController::class, 'edit'])->name('kb-mket.edit');
    Route::put('/kb-mket/{kb_mket}', [JumlahKbMketController::class, 'update'])->name('kb-mket.update');
    Route::delete('/kb-mket/{kb_mket}', [JumlahKbMketController::class, 'destroy'])->name('kb-mket.destroy');

    Route::get('/kb-non-mket', [JumlahKbNonMketController::class, 'index'])->name('kb-non-mket.index');
    Route::get('/kb-non-mket/create', [JumlahKbNonMketController::class, 'create'])->name('kb-non-mket.create');
    Route::post('/kb-non-mket', [JumlahKbNonMketController::class, 'store'])->name('kb-non-mket.store');
    Route::get('/kb-non-mket/{kb_non_mket}/edit', [JumlahKbNonMketController::class, 'edit'])->name('kb-non-mket.edit');
    Route::put('/kb-non-mket/{kb_non_mket}', [JumlahKbNonMketController::class, 'update'])->name('kb-non-mket.update');
    Route::delete('/kb-non-mket/{kb_non_mket}', [JumlahKbNonMketController::class, 'destroy'])->name('kb-non-mket.destroy');

    Route::get('/ibu-hamil', [JumlahIbuHamilController::class, 'index'])->name('ibu-hamil.index');
    Route::get('/ibu-hamil/create', [JumlahIbuHamilController::class, 'create'])->name('ibu-hamil.create');
    Route::post('/ibu-hamil', [JumlahIbuHamilController::class, 'store'])->name('ibu-hamil.store');
    Route::get('/ibu-hamil/{ibu_hamil}/edit', [JumlahIbuHamilController::class, 'edit'])->name('ibu-hamil.edit');
    Route::put('/ibu-hamil/{ibu_hamil}', [JumlahIbuHamilController::class, 'update'])->name('ibu-hamil.update');
    Route::delete('/ibu-hamil/{ibu_hamil}', [JumlahIbuHamilController::class, 'destroy'])->name('ibu-hamil.destroy');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

require __DIR__ . '/auth.php';
