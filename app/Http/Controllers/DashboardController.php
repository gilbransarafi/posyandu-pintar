<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        // Pilihan A: Cari file di public/images/posyandu/
        $files = glob(public_path('images/posyandu/*.{jpg,jpeg,png,gif,webp}'), GLOB_BRACE) ?: [];

        // Ubah path ke URL asset
        $images = array_map(function($fullpath) {
            return asset('images/posyandu/' . basename($fullpath));
        }, $files);

        // Kirim ke view resources/views/dashboard.blade.php
        return view('dashboard', compact('images'));
    }
}
