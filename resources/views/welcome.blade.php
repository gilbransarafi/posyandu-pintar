<!doctype html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>POSYANDUPINTAR — Sistem Informasi Posyandu</title>

  <!-- Tailwind CDN (cepat untuk development/testing) -->
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  @vite('resources/css/app.css')

  <style>
    .card-shadow { box-shadow: 0 10px 30px rgba(2,6,23,0.08); border-radius: 14px; }
    .green-accent { background: linear-gradient(180deg,#0f766e22,#10b98111); }
  </style>
</head>
<body class="antialiased text-gray-700 bg-gray-50">

  @php
    // paths
    $hero = file_exists(public_path('images/posyandu/hero.jpg')) ? asset('images/posyandu/hero.jpg') : 'https://via.placeholder.com/1600x700';
    $thumb = file_exists(public_path('images/posyandu/Foto1.jpeg')) ? asset('images/posyandu/Foto1.jpeg') : 'https://via.placeholder.com/500x350';
    $gallery = glob(public_path('images/posyandu/*.{jpg,jpeg,png,gif,webp}'), GLOB_BRACE) ?: [];
    // remove logo/hero/thumb duplicates if you prefer, but it's fine to show all
  @endphp

 <!-- 🟩 NAVBAR: Transparan di atas, putih saat scroll -->
<header id="site-header" class="absolute inset-x-0 top-0 z-30 transition-all duration-500">
  <nav id="main-nav"
       class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between bg-transparent transition-all duration-500 ease-in-out"
       aria-label="Main navigation">

    <!-- 🟩 LOGO + BRAND -->
    <div class="flex items-center gap-3">
      @if(file_exists(public_path('images/Logo Posyandu.png')))
        <img id="logo-img" src="{{ asset('images/logo-posyandu.png') }}" alt="logo" class="w-12 h-12 object-contain">
      @else
        <div id="logo-fallback" class="w-12 h-12 rounded-full bg-green-700 flex items-center justify-center text-white font-bold">SD</div>
      @endif
      <div class="hidden sm:block">
        <div id="brand-title" class="font-semibold text-white text-lg transition-colors duration-300">POSYANDU PINTAR</div>
        <div id="brand-sub" class="text-xs text-gray-200 transition-colors duration-300">Sistem Informasi Posyandu</div>
      </div>
    </div>

    <!-- 🟩 NAV LINKS -->
    <div class="flex items-center gap-6">
      <div id="nav-links" class="hidden md:flex items-center gap-6 text-sm">
        <a href="#" class="nav-link text-white hover:underline transition-colors duration-300">Beranda</a>
        <a href="#tentang-kami" class="nav-link text-white hover:underline transition-colors duration-300">Tentang Kami</a>
        <a href="#dokumentasi" class="nav-link text-white hover:underline transition-colors duration-300">Dokumentasi</a>
        <a href="#footer" class="nav-link text-white hover:underline transition-colors duration-300">Hubungi Kami</a>
      </div>

      <!-- 🟩 LOGIN BUTTON -->
      <a id="login-btn" href="{{ route('login') }}"
         class="px-4 py-2 rounded-full border transition-all duration-300 text-white border-white/80 hover:bg-white/90 hover:text-black">
        Login
      </a>

      <!-- 🟩 Mobile toggle (opsional) -->
      <button id="mobile-toggle" class="md:hidden ml-2 text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 7h16M4 12h16M4 17h16"/>
        </svg>
      </button>
    </div>
  </nav>
</header>

<!-- 🟩 Spacer agar layout tidak meloncat saat navbar menjadi fixed -->
<div id="nav-spacer" class="hidden"></div>

<script>
  // 🟩 Config: scroll minimal sebelum navbar berubah
  const SHOW_AFTER = 50;

  const header = document.getElementById('site-header');
  const nav = document.getElementById('main-nav');
  const spacer = document.getElementById('nav-spacer');
  const navLinks = document.querySelectorAll('.nav-link');
  const loginBtn = document.getElementById('login-btn');
  const brandTitle = document.getElementById('brand-title');
  const brandSub = document.getElementById('brand-sub');

  // 🟩 Atur tinggi spacer agar layout tidak bergeser
  function setSpacerHeight() {
    spacer.style.height = nav.offsetHeight + 'px';
  }

  // 🟩 Jalankan saat pertama kali load
  window.addEventListener('load', () => {
    setSpacerHeight();
    onScroll();
  });

  window.addEventListener('resize', setSpacerHeight);

  // 🟩 Efek saat discroll
  function onScroll() {
    const y = window.scrollY || window.pageYOffset;

    if (y > SHOW_AFTER) {
      // 🟩 Navbar berubah jadi fixed & putih penuh
      header.classList.remove('absolute');
      header.classList.add('fixed', 'top-0', 'left-0', 'right-0', 'bg-white/90', 'backdrop-blur-lg', 'shadow-md');

      nav.classList.remove('bg-transparent');
      nav.classList.add('bg-transparent'); // biar tetap mengikuti header putih blur

      // 🟩 Ubah warna teks jadi gelap
      navLinks.forEach(a => {
        a.classList.remove('text-white');
        a.classList.add('text-gray-800');
      });
      loginBtn.classList.remove('text-white', 'border-white/80', 'hover:bg-white/90', 'hover:text-black');
      loginBtn.classList.add('text-gray-800', 'border-gray-300', 'hover:bg-gray-100');

      brandTitle.classList.remove('text-white');
      brandTitle.classList.add('text-gray-800');
      brandSub.classList.remove('text-gray-200');
      brandSub.classList.add('text-gray-500');

      spacer.classList.remove('hidden');
    } else {
      // 🟩 Navbar kembali transparan di atas
      header.classList.remove('fixed', 'bg-white/90', 'backdrop-blur-lg', 'shadow-md');
      header.classList.add('absolute');

      nav.classList.remove('bg-transparent'); // reset agar kembali bening
      nav.classList.add('bg-transparent');

      navLinks.forEach(a => {
        a.classList.remove('text-gray-800');
        a.classList.add('text-white');
      });
      loginBtn.classList.remove('text-gray-800', 'border-gray-300', 'hover:bg-gray-100');
      loginBtn.classList.add('text-white', 'border-white/80', 'hover:bg-white/90', 'hover:text-black');

      brandTitle.classList.remove('text-gray-800');
      brandTitle.classList.add('text-white');
      brandSub.classList.remove('text-gray-500');
      brandSub.classList.add('text-gray-200');

      spacer.classList.add('hidden');
    }
  }

  // 🟩 Optimasi performa scroll
  let ticking = false;
  window.addEventListener('scroll', () => {
    if (!ticking) {
      window.requestAnimationFrame(() => {
        onScroll();
        ticking = false;
      });
      ticking = true;
    }
  });
</script>



<!-- HERO -->
<div class="h-[450px] md:h-[750px] w-full relative overflow-hidden">

    <div id="hero-track" class="flex h-full w-full transition-transform duration-1000 ease-in-out">
    
    <div class="hero-slide w-full h-full flex-shrink-0 bg-cover bg-center" 
         style="background-image: url('{{ asset('images/kader formal pose.jpg') }}');">
    </div>
    
    <div class="hero-slide w-full h-full flex-shrink-0 bg-cover bg-center" 
         style="background-image: url('{{ asset('images/kader foto.jpg') }}');">
    </div>
    
    </div>

    <div class="absolute inset-0 flex items-center">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
          <div class="text-white">
            <h1 class="text-4xl sm:text-5xl md:text-5xl font-extrabold leading-tight">
              Selamat Datang<br>
              <span class="inline-block">di <span class="text-white/95">POSYANDU PINTAR</span></span>
            </h1>

            <p class="mt-4 max-w-xl text-base md:text-lg text-white/90">
              Sistem Informasi Posyandu
            </p>

            <!-- social icons -->
              <div class="mt-5 flex items-center gap-3">
                <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20">
                  <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.99H8.896v-2.888h1.542V9.845c0-1.523.909-2.364 2.303-2.364.667 0 1.366.12 1.366.12v1.505h-.769c-.758 0-.994.472-.994.957v1.15h1.695l-.271 2.888h-1.424v6.99C18.343 21.128 22 16.991 22 12z"/></svg>
                </a>
                <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20">
                  <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c5.47 0 9.9 4.431 9.9 9.9 0 5.47-4.431 9.9-9.9 9.9S2.1 17.533 2.1 12.063c0-5.47 4.43-9.9 9.9-9.9zm0 1.8a8.1 8.1 0 100 16.2 8.1 8.1 0 000-16.2zM7.5 9.5a.9.9 0 110-1.8.9.9 0 010 1.8zm4.5 0.2c-1.94 0-3.5 1.56-3.5 3.5s1.56 3.5 3.5 3.5 3.5-1.56 3.5-3.5-1.56-3.5-3.5-3.5z"/></svg>
                </a>
                <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20">
                  <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M21.6 7.2c-.2.8-.8 1.4-1.6 1.6.6-.4 1-1 1.2-1.8-.6.4-1.4.6-2.2.8A3.6 3.6 0 0016 6c-2 0-3.6 1.6-3.6 3.6 0 .3 0 .6.1.9C8.4 10.2 5.1 8.4 3 5.7c-.3.5-.5 1-.5 1.6 0 1.2.6 2.2 1.5 2.8-.6 0-1.2-.2-1.7-.5 0 1.6 1.1 2.9 2.6 3.2-.5.1-1 .2-1.6.1.5 1.6 2 2.8 3.7 2.9A7.3 7.3 0 013 18.6C4.5 19.7 6.2 20.4 8 20.4c7.6 0 11.8-6.3 11.8-11.8v-.5c.9-.6 1.5-1.5 1.9-2.5z"/></svg>
                </a>
              </div>
            </div>

            <!-- right empty so text sits left -->
            <div class="hidden md:block"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

 <!-- 🟩 SECTION: Layanan Posyandu Pintar -->
<main id="layanan" class="max-w-7xl mx-auto px-6 -mt-12">
  <!-- 🟩 CARD UCAPAN SELAMAT DATANG -->
  <div class="bg-white card-shadow p-6 rounded-lg mb-8 mt-24 text-center">
    <h2 class="text-3xl font-bold text-blue-600">SELAMAT DATANG DI POSYANDU ILP PINTAR</h2>
    <p class="mt-2 text-gray-600">
      Melayani ibu hamil, bayi, balita, remaja, dewasa, pralansia dan lansia.
    </p>
  </div>

  <!-- 🟩 SECTION: Layanan utama (3 kolom dengan border & shadow) -->
  <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
    <!-- 🟩 Kolom 1 -->
    <div class="bg-white border border-gray-200 p-8 rounded-xl shadow-sm hover:shadow-md text-center hover:-translate-y-1 transition-all duration-300">
      <div class="text-4xl">🤝</div>
      <div class="font-semibold text-blue-700 mt-3 text-lg">Kolaborasi</div>
      <p class="text-sm text-gray-600 mt-2">
        Terhubung dengan kader dan tenaga medis melalui sistem digital yang mudah digunakan dan efisien.
      </p>
    </div>

    <!-- 🟩 Kolom 2 -->
    <div class="bg-white border border-gray-200 p-8 rounded-xl shadow-sm hover:shadow-md text-center hover:-translate-y-1 transition-all duration-300">
      <div class="text-4xl">📋</div>
      <div class="font-semibold text-blue-700 mt-3 text-lg">Partisipasi</div>
      <p class="text-sm text-gray-600 mt-2">
        Ikut serta dalam kegiatan posyandu, mencatat data kesehatan seluruh siklus hidup manusi.
      </p>
    </div>

    <!-- 🟩 Kolom 3 -->
    <div class="bg-white border border-gray-200 p-8 rounded-xl shadow-sm hover:shadow-md text-center hover:-translate-y-1 transition-all duration-300">
      <div class="text-4xl">🌿</div>
      <div class="font-semibold text-blue-700 mt-3 text-lg">Manfaat</div>
      <p class="text-sm text-gray-600 mt-2">
        Meningkatkan transparansi, efisiensi, dan akuntabilitas dalam pelayanan kesehatan masyarakat.
      </p>
    </div>
  </section>
</main>

   <!-- Section yang sudah disesuaikan -->
<section id="tentang-kami" class="bg-[color: #b9e6b6] py-14 px-6 md:px-16 rounded-none mb-12">
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
    <!-- KIRI: Gambar -->
    <div class="relative flex justify-center md:justify-start">
      <!-- Kotak gambar besar -->
      <div class="relative">
        <img
          src="images/utama.png" 
          alt="Kegiatan"
          class="rounded-[20px] shadow-[0_30px_40px_rgba(0,0,0,0.12)] w-[520px] h-[520px] object-cover md:object-top"
        />

        <!-- Gambar kecil (overlapped) -->
        <div
          class="absolute left-6 bottom-6 w-44 h-64 rounded-[18px] bg-green-700 border-8 border-white shadow-[0_12px_20px_rgba(0,0,0,0.12)] overflow-hidden"
          style="transform: translateY(30%);"
        >
          <img
            src="images/kedua.png"
            alt="Mini"
            class="w-full h-full object-cover"
          />
        </div>

        <!-- Lingkaran info -->
        <div
          class="absolute -right-6 top-4 bg-blue-700 text-white rounded-full px-6 py-4 text-center shadow-lg flex flex-col items-center justify-center"
          style="width:110px; height:110px;"
        >
          <span class="font-extrabold text-lg leading-none">1,485+</span>
          <span class="text-[11px] leading-tight font-light">Trusted Clients</span>
        </div>
      </div>
    </div>

    <!-- KANAN: Teks -->
    <div class="text-blue-700 md:pl-8">
      <h4 class="text-blue-700 font-semibold text-sm uppercase tracking-widest mb-3">
        SISTEM INFORMASI POSYANDU ILP PINTAR
      </h4>

      <h2 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-5">
        Apa Kegunaan Kami?<br />
        Sistem Informasi POSYANDU ILP PINTAR
      </h2>

      <p class="text-blue-900/80 text-base leading-relaxed mb-8 max-w-prose">
        Sistem Informasi POSYANDU ILP PINTAR hadir untuk mendukung pelayanan kesehatan masyarakat yang terpadu dan efisien. 
        Sistem ini membantu kader, tenaga medis, serta masyarakat dalam mengelola data kesehatan secara digital untuk seluruh tahapan 
        kehidupan — mulai dari ibu hamil, bayi, balita, remaja, hingga lansia.
      </p>

      <!-- fitur kotak -->
      <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-6">
        <div class="flex items-start gap-4 mb-4">
          <div class="flex-shrink-0 w-11 h-11 rounded-full bg-green-700 text-white flex items-center justify-center shadow">
            <!-- icon placeholder -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <div>
            <div class="font-semibold text-green-700">Layanan Terpercaya</div>
            <div class="text-blue-700/70 text-sm">Menjamin keakuratan dan keamanan data kesehatan masyarakat melalui sistem berbasis digital yang terintegrasi.</div>
          </div>
        </div>

        <div class="flex items-start gap-4 mb-4">
          <div class="flex-shrink-0 w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18" />
            </svg>
          </div>
          <div>
            <div class="font-semibold text-blue-700">Akses Cepat & Mudah</div>
            <div class="text-blue-900/70 text-sm">Masyarakat dan kader dapat dengan mudah mencatat, memantau, dan mengakses data kesehatan melalui perangkat digital.</div>
          </div>
        </div>

        <div class="flex items-start gap-4">
          <div class="flex-shrink-0 w-11 h-11 rounded-full bg-red-500 text-white flex items-center justify-center shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
            </svg>
          </div>
          <div>
            <div class="font-semibold text-red-600">Teruji dan Andal</div>
            <div class="text-blue-900/70 text-sm">Mendukung peningkatan transparansi, efisiensi, dan akuntabilitas dalam pelayanan kesehatan menuju Posyandu modern berbasis teknologi.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



    <!-- galeri -->
    <section id="dokumentasi" class="bg-white card-shadow p-6 rounded-lg mb-10">
      <h3 class="text-xl font-semibold mb-2">Dokumentasi Pelaksanaan Posyandu</h3>
      <p class="text-sm text-gray-500 mb-4">Kegiatan dan fasilitas.</p>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @if(count($gallery) > 0)
          @foreach($gallery as $img)
            <figure class="overflow-hidden rounded-lg shadow">
              <img src="{{ asset('images/posyandu/' . basename($img)) }}" alt="Foto posyandu {{ $loop->iteration }}" class="w-full h-80 object-cover">
            </figure>
          @endforeach
        @else
          <div class="text-center text-gray-500 py-10">Belum ada foto. Tambahkan file ke <code>public/images/posyandu/</code></div>
        @endif
      </div>
    </section>

    <!-- sekilas / video placeholder -->
    <section class="mb-12">
      <div class="card-shadow bg-white p-6 rounded-lg">
        <h4 class="font-semibold mb-4">Sekilas POSYANDU PINTAR</h4>
        <div class="w-full h-[500px] md:h-[650px] rounded-lg overflow-hidden shadow-lg bg-black flex items-center justify-center">
    
          <video autoplay muted loop playsinline class="w-full h-full object-contain">
            <source src="{{ asset('videos/video placeholder 1.mp4') }}" type="video/mp4">
            Browser Anda tidak mendukung tag video.
          </video>

        </div>
      </div>
    </section>
  </main>

  <!-- footer -->
  <footer id="footer" class="bg-blue-900 text-gray-200 py-8 mt-12">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-6">
      <div>
        <div class="flex items-center gap-3">
          @if(file_exists(public_path('images/logo-posyandu.png')))
            <img src="{{ asset('images/logo-posyandu.png') }}" alt="logo" class="w-10 h-10">
          @else
            <div class="w-10 h-10 bg-white/10 rounded flex items-center justify-center text-white font-bold">SD</div>
          @endif
          <div>
            <div class="font-bold">POSYANDU PINTAR</div>
            <div class="text-xs">Sistem Informasi Posyandu</div>
          </div>
        </div>
      </div>

      <div>
        <div class="font-semibold mb-2">Navigasi</div>
        <ul class="text-sm space-y-1">
          <li><a href="#" class="hover:underline">Beranda</a></li>
          <li><a href="#tentang-kami" class="hover:underline">Tentang</a></li>
          <li><a href="#dokumentasi" class="hover:underline">Dokumentasi</a></li>
        </ul>
      </div>

      <div>
        <div class="font-semibold mb-2">Kontak</div>
        <div class="text-sm">Jl. Rempoa Raya, RT 02/RW 10, Kecamatan Ciputat Timur, Tangerang Selatan.</div>
        <div class="text-sm mt-2">Telp : +628973794424</div>
      </div>
    </div>

    <div class="text-center text-xs text-gray-300 mt-6">© 2025 POSYANDU PINTAR. Semua Hak Dilindungi.</div>
  </footer>

  <script>
    // --- Hero Slideshow (Geser ke Samping) ---
    (function() {
        const track = document.getElementById('hero-track');
        if (!track) return;
        
        const slides = track.querySelectorAll('.hero-slide');
        if (slides.length <= 1) return;

        let currentSlide = 0;
        const slideInterval = 5000; // 5 detik

        setInterval(() => {
            // Hitung slide berikutnya
            currentSlide = (currentSlide + 1) % slides.length;
            
            // Pindahkan track-nya
            track.style.transform = `translateX(-${currentSlide * 100}%)`;

        }, slideInterval);
    })();
</script>

</body>
</html>

</body>
</html>
