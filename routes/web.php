<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosyanduRekapController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\JumlahWusPusController;
use App\Http\Controllers\JumlahPusKbController;
use App\Http\Controllers\JumlahKbMketController;
use App\Http\Controllers\JumlahKbNonMketController;
use App\Http\Controllers\JumlahIbuHamilController;

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

require __DIR__.'/auth.php';
