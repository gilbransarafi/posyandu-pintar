<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome'); // ganti 'landing' ke resources/views/landing.blade.php atau view yang sesuai
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';