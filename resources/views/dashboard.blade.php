<x-app-layout>
    <x-slot name="header">
        {{-- biarkan header kecil bawaan --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        // fallback hero dan asset lainnya — pastikan kamu menaruh file di public/images/posyandu/
        $hero = file_exists(public_path('images/posyandu/hero.jpg')) ? asset('images/posyandu/hero.jpg') : 'https://via.placeholder.com/1600x600';
        $thumb = file_exists(public_path('images/posyandu/Foto1.jpeg')) ? asset('images/posyandu/Foto1.jpeg') : 'https://via.placeholder.com/400x300';
        // Jika controller mengirim $images gunakan itu, kalau tidak, ambil dari public
        $images = $images ?? (glob(public_path('images/posyandu/*.{jpg,jpeg,png,gif,webp}'), GLOB_BRACE) ?: []);
    @endphp

    <div class="py-0">
        <!-- HERO besar -->
        <section class="w-full h-72 md:h-96 bg-cover bg-center" style="background-image: url('{{ $hero }}')">
            <div class="w-full h-full bg-black bg-opacity-40 flex items-center">
                <div class="max-w-7xl mx-auto px-6 text-white">
                    <h1 class="text-3xl md:text-5xl font-extrabold leading-tight">Selamat Datang<br>di Posyandu Pintar</h1>
                    <p class="mt-3 max-w-2xl text-sm md:text-base text-gray-200">Sistem Informasi untuk mendukung penyelenggaraan kegiatan kesehatan masyarakat secara digital.</p>
                    <div class="mt-5">
                        <a href="{{ route('dashboard') }}" class="inline-block bg-white text-blue-700 px-4 py-2 rounded-md font-medium mr-2">Dashboard</a>
                        <a href="#layanan" class="inline-block border border-white text-white px-4 py-2 rounded-md">Pelajari</a>
                    </div>
                </div>
            </div>
        </section>

        <main class="max-w-7xl mx-auto sm:px-6 lg:px-8 -mt-12">
            <div class="grid grid-cols-1 gap-8">
                <!-- Welcome Card (floating) -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 card-shadow">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold text-blue-600">Selamat Datang di Posyandu Pintar</h1>
                        <p class="mt-2 text-gray-600">Menyediakan layanan kesehatan ibu & anak, imunisasi, dan edukasi masyarakat.</p>
                    </div>
                </div>

                <!-- Layanan + Green band + Gallery layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Left: Main content (galeri + green band + statistik) --}}
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Galeri kecil (card) -->
                        <section class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                            <h3 class="text-2xl font-semibold mb-2 text-gray-700">Galeri Posyandu</h3>
                            <p class="text-sm text-gray-500 mb-4">Kegiatan dan fasilitas di posyandu.</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @if(!empty($images) && count($images) > 0)
                                    @foreach($images as $img)
                                        <figure class="overflow-hidden rounded-xl shadow">
                                            <img src="{{ asset('images/posyandu/' . basename($img)) }}" alt="Foto posyandu {{ $loop->iteration }}" class="w-full h-48 object-cover">
                                        </figure>
                                    @endforeach
                                @else
                                    {{-- fallback placeholders --}}
                                    <figure class="overflow-hidden rounded-xl shadow">
                                        <img src="https://via.placeholder.com/800x500?text=Posyandu+1" alt="Placeholder 1" class="w-full h-48 object-cover">
                                    </figure>
                                    <figure class="overflow-hidden rounded-xl shadow">
                                        <img src="https://via.placeholder.com/800x500?text=Posyandu+2" alt="Placeholder 2" class="w-full h-48 object-cover">
                                    </figure>
                                    <figure class="overflow-hidden rounded-xl shadow">
                                        <img src="https://via.placeholder.com/800x500?text=Posyandu+3" alt="Placeholder 3" class="w-full h-48 object-cover">
                                    </figure>
                                @endif
                            </div>
                        </section>

                        <!-- blue Feature Band -->
                        <section class="p-6 rounded-lg" style="background: linear-gradient(180deg,#BFDBFEe2,#1E40AF11);">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                                <div class="flex justify-center md:justify-start">
                                    <div class="w-56 rounded-lg overflow-hidden bg-white shadow">
                                        <img src="{{ $thumb }}" alt="thumbnail" class="w-full h-40 object-cover">
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <h3 class="text-xl font-bold">Apa Kegunaan Kami? Sistem Informasi Posyandu Pintar</h3>
                                    <p class="text-sm text-gray-800 mt-2">Mengelola data kesehatan balita, ibu hamil, dan lansia secara digital untuk mempermudah pemantauan dan pelaporan kader.</p>

                                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                                        <div class="p-3 bg-white rounded shadow-sm">
                                            <div class="font-semibold text-blue-700">Pendataan Akurat</div>
                                            <div class="text-gray-600">Mencatat data gizi, imunisasi, dan riwayat kesehatan balita secara terpusat dan digital.</div>
                                        </div>
                                        <div class="p-3 bg-white rounded shadow-sm">
                                            <div class="font-semibold text-blue-700">Pemantauan Mudah</div>
                                            <div class="text-gray-600">Kader dapat melihat grafik pertumbuhan anak dan jadwal imunisasi kapan saja.</div>
                                        </div>
                                        <div class="p-3 bg-white rounded shadow-sm">
                                            <div class="font-semibold text-blue-700">Pelaporan Cepat</div>
                                            <div class="text-gray-600">Membuat laporan bulanan Posyandu (LBS) secara otomatis tanpa rekap manual.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Statistik ringkas -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div class="p-6 bg-white rounded shadow text-center">
                                <div class="text-2xl font-bold">5+</div>
                                <div class="text-sm text-gray-600 mt-1">Years Of Experience</div>
                            </div>
                            <div class="p-6 bg-white rounded shadow text-center">
                                <div class="text-2xl font-bold">3,452+</div>
                                <div class="text-sm text-gray-600 mt-1">Total View</div>
                            </div>
                            <div class="p-6 bg-white rounded shadow text-center">
                                <div class="text-2xl font-bold">751+</div>
                                <div class="text-sm text-gray-600 mt-1">Active User</div>
                            </div>
                            <div class="p-6 bg-white rounded shadow text-center">
                                <div class="text-2xl font-bold">592+</div>
                                <div class="text-sm text-gray-600 mt-1">Positive Reviews</div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Services / sidebar --}}
                    <aside class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                        <h3 class="text-2xl font-semibold mb-4 text-gray-700">Layanan Posyandu</h3>
                        <p class="text-sm text-gray-500 mb-6">Pelayanan rutin yang kami sediakan untuk ibu dan anak.</p>

                        <div class="grid grid-cols-1 gap-3">
                            <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                                <div class="text-2xl">📌</div>
                                <div>
                                    <div class="font-semibold text-gray-800">Penimbangan Balita</div>
                                    <div class="text-sm text-gray-600">Pantauan pertumbuhan dan gizi.</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                                <div class="text-2xl">💉</div>
                                <div>
                                    <div class="font-semibold text-gray-800">Imunisasi Anak</div>
                                    <div class="text-sm text-gray-600">Jadwal imunisasi lengkap sesuai program.</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                                <div class="text-2xl">🧪</div>
                                <div>
                                    <div class="font-semibold text-gray-800">Pemeriksaan Ibu Hamil</div>
                                    <div class="text-sm text-gray-600">Konsultasi dan pemeriksaan kehamilan.</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                                <div class="text-2xl">🩺</div>
                                <div>
                                    <div class="font-semibold text-gray-800">Konsultasi Kesehatan</div>
                                    <div class="text-sm text-gray-600">Sesi tanya jawab dengan tenaga kesehatan.</div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </main>
    </div>

    {{-- small inline style for card shadow if your app css doesnt include it --}}
    <style>
        .card-shadow { box-shadow: 0 8px 22px rgba(8,20,34,0.06); border-radius: 12px; }
    </style>
</x-app-layout>
