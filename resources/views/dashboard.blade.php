<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h1 class="text-3xl font-bold text-green-600">Selamat Datang di Posyandu Pintar</h1>
                    <p class="mt-2 text-gray-600">Menyediakan layanan kesehatan ibu & anak, imunisasi, dan edukasi masyarakat.</p>
                </div>
            </div>

            <!-- Foto Posyandu -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-4 text-gray-700">Galeri Posyandu</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <img src="https://via.placeholder.com/400x250" class="rounded-xl shadow">
                    <img src="https://via.placeholder.com/400x250" class="rounded-xl shadow">
                    <img src="https://via.placeholder.com/400x250" class="rounded-xl shadow">
                </div>
            </div>

            <!-- Layanan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-4 text-gray-700">Layanan Posyandu</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-green-100 rounded-xl shadow">📌 Penimbangan Balita</div>
                    <div class="p-4 bg-green-100 rounded-xl shadow">💉 Imunisasi Anak</div>
                    <div class="p-4 bg-green-100 rounded-xl shadow">🧪 Pemeriksaan Ibu Hamil</div>
                    <div class="p-4 bg-green-100 rounded-xl shadow">🩺 Konsultasi Kesehatan</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
