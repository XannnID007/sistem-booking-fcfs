<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Musik Premium - Booking Mudah & Cepat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .hero-bg::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.1) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #FBBF24 0%, #F59E0B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }

        .feature-card {
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
        }

        .gallery-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.6) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .gallery-item:hover::before {
            opacity: 1;
        }
    </style>
</head>

<body class="text-slate-800">

    <!-- Navbar with Scroll Effect -->
    <nav x-data="{ scrolled: false }" @scroll.window="scrolled = window.scrollY > 50"
        :class="scrolled ? 'glass-nav shadow-md' : 'bg-transparent'"
        class="fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-24 h-24 object-contain">
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" :class="scrolled ? 'text-slate-700' : 'text-white'"
                        class="px-5 py-2 hover:text-amber-600 transition-colors font-semibold text-sm">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-all font-bold text-sm shadow-lg hover:shadow-xl">
                        Daftar Gratis
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section - Attractive -->
    <section class="hero-bg min-h-screen flex items-center justify-center px-4 relative">
        <div class="max-w-5xl mx-auto text-center relative z-10 py-24">
            <div class="mb-6">
                <span
                    class="inline-block px-4 py-2 bg-amber-500/20 text-amber-400 rounded-full text-sm font-semibold mb-6 border border-amber-500/30">
                    🎵 Platform Booking Studio Terpercaya
                </span>
            </div>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                Wujudkan Karya Musikmu di
                <span class="gradient-text block mt-2">Studio Premium Kami</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-300 max-w-3xl mx-auto mb-10 leading-relaxed">
                Booking studio musik berkualitas tinggi dengan mudah dan cepat. Sistem real-time, pembayaran fleksibel,
                dan fasilitas lengkap untuk mendukung kreativitas Anda.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('customer.studio.index') }}"
                    class="px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-lg hover:from-amber-600 hover:to-orange-700 transition-all font-bold text-base shadow-2xl hover:shadow-amber-500/50 transform hover:scale-105">
                    🎸 Mulai Booking Sekarang
                </a>
                <a href="#features"
                    class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white rounded-lg hover:bg-white/20 transition-all font-semibold text-base border border-white/20">
                    Pelajari Lebih Lanjut
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-8 max-w-3xl mx-auto mt-16">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-1">100+</div>
                    <div class="text-sm text-slate-400">Studio Tersedia</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-1">1000+</div>
                    <div class="text-sm text-slate-400">Booking Selesai</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-1">98%</div>
                    <div class="text-sm text-slate-400">Kepuasan</div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                </path>
            </svg>
        </div>
    </section>

    <!-- Features Section - Attractive -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
                    Kenapa Pilih <span class="gradient-text">Kami?</span>
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Pengalaman booking studio yang mudah, cepat, dan terpercaya
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="feature-card bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-8 border border-amber-200 shadow-md">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Booking Instan</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Sistem FCFS yang transparan. Cek ketersediaan real-time dan booking langsung dalam hitungan
                        menit.
                    </p>
                </div>
                <div
                    class="feature-card bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 border border-green-200 shadow-md">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Pembayaran Aman</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Sistem pembayaran QRIS yang aman, terverifikasi, dan mendukung DP maupun pembayaran penuh.
                    </p>
                </div>
                <div
                    class="feature-card bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8 border border-blue-200 shadow-md">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Studio Premium</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Pilihan studio dengan fasilitas lengkap, akustik berkualitas, dan peralatan profesional.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section - Enhanced -->
    <section class="py-20 bg-gradient-to-b from-slate-50 to-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
                    Galeri <span class="gradient-text">Studio Kami</span>
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Jelajahi berbagai pilihan studio dengan fasilitas premium dan teknologi terkini
                </p>
            </div>

            <!-- Main Featured Gallery -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Large Featured Image -->
                <div class="md:row-span-2 gallery-item group relative rounded-3xl overflow-hidden shadow-2xl">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        src="{{ asset('images/bg1.jpg') }}" alt="Studio Premium">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-8 z-10">
                        <div class="text-white">
                            <h3 class="text-2xl font-bold mb-2">Studio Premium A</h3>
                            <p class="text-sm text-gray-200">Fasilitas Recording Profesional</p>
                        </div>
                    </div>
                </div>

                <!-- Top Right Image -->
                <div class="gallery-item group relative rounded-3xl overflow-hidden shadow-xl">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        src="{{ asset('images/bg2.jpg') }}" alt="Studio Recording">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6 z-10">
                        <div class="text-white">
                            <h3 class="text-xl font-bold mb-1">Studio Recording</h3>
                            <p class="text-xs text-gray-200">Soundproof & High-Tech</p>
                        </div>
                    </div>
                </div>

                <!-- Bottom Right Image -->
                <div class="gallery-item group relative rounded-3xl overflow-hidden shadow-xl">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        src="{{ asset('images/bg3.jpg') }}" alt="Studio Rehearsal">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6 z-10">
                        <div class="text-white">
                            <h3 class="text-xl font-bold mb-1">Studio Rehearsal</h3>
                            <p class="text-xs text-gray-200">Perfect for Band Practice</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Small Gallery -->
            <div class="grid grid-cols-3 gap-6">
                <div class="gallery-item group relative rounded-2xl overflow-hidden shadow-lg aspect-video">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        src="{{ asset('images/bg1.jpg') }}" alt="Control Room">
                    <div
                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center z-10">
                        <span class="text-white font-bold text-sm">Control Room</span>
                    </div>
                </div>
                <div class="gallery-item group relative rounded-2xl overflow-hidden shadow-lg aspect-video">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        src="{{ asset('images/bg2.jpg') }}" alt="Live Room">
                    <div
                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center z-10">
                        <span class="text-white font-bold text-sm">Live Room</span>
                    </div>
                </div>
                <div class="gallery-item group relative rounded-2xl overflow-hidden shadow-lg aspect-video">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        src="{{ asset('images/bg3.jpg') }}" alt="Mixing Studio">
                    <div
                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center z-10">
                        <span class="text-white font-bold text-sm">Mixing Studio</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
                    Lokasi <span class="gradient-text">Studio</span>
                </h2>
                <p class="text-lg text-slate-600">Kunjungi kami di lokasi strategis dan mudah dijangkau</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-900 mb-1">Alamat</h3>
                            <p class="text-slate-600">Jl. Contoh No. 123, Kota Bandung, Jawa Barat 40111</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-900 mb-1">Jam Operasional</h3>
                            <p class="text-slate-600">Senin - Minggu: 10:00 - 23:00 WIB</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-900 mb-1">Kontak</h3>
                            <p class="text-slate-600">(022) 123-4567</p>
                            <p class="text-slate-600">booking@studiokami.com</p>
                        </div>
                    </div>
                </div>
                <div class="aspect-video rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.902348545229!2d107.61821037596045!3d-6.902206093096843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64c5e8866e5%3A0x34be56247c1f83c!2sGedung%20Sate!5e0!3m2!1sid!2sid!4v1696435368383!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer - Enhanced -->
    <footer
        class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-slate-300 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <!-- Main Footer Content -->
            <div class="py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10">
                <!-- Brand Section -->
                <div class="lg:col-span-5">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo"
                        class="w-32 h-32 object-contain mb-4 brightness-0 invert">
                    <p class="text-slate-400 mb-6 leading-relaxed max-w-md">
                        Platform booking studio musik terpercaya dengan sistem modern, pembayaran aman, dan studio
                        berkualitas premium di seluruh Indonesia.
                    </p>

                    <!-- Social Media -->
                    <div class="mb-6">
                        <p class="text-white font-semibold mb-3">Ikuti Kami</p>
                        <div class="flex gap-3">
                            <a href="#"
                                class="group w-11 h-11 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-gradient-to-r hover:from-amber-500 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-amber-500/50">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="group w-11 h-11 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-gradient-to-r hover:from-amber-500 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-amber-500/50">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="group w-11 h-11 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-gradient-to-r hover:from-amber-500 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-amber-500/50">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="group w-11 h-11 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-gradient-to-r hover:from-amber-500 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-amber-500/50">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="lg:col-span-2">
                    <h4 class="text-white font-bold mb-4 text-lg">Menu</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('login') }}"
                                class="text-slate-400 hover:text-amber-500 transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Masuk
                            </a></li>
                        <li><a href="{{ route('register') }}"
                                class="text-slate-400 hover:text-amber-500 transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Daftar
                            </a></li>
                        <li><a href="#features"
                                class="text-slate-400 hover:text-amber-500 transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Fitur
                            </a></li>
                        <li><a href="#"
                                class="text-slate-400 hover:text-amber-500 transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Tentang Kami
                            </a></li>
                    </ul>
                </div>

                <!-- Studio -->
                <div class="lg:col-span-2">
                    <h4 class="text-white font-bold mb-4 text-lg">Studio</h4>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-slate-400 hover:text-amber-500 transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Premium Studio
                            </a></li>
                        <li><a href="#"
                                class="text-slate-400 hover:text-amber-500 transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Recording Studio
                            </a></li>
                        <li><a href="#"
                                class="text-slate-400 hover:text-amber-500 transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Rehearsal Studio
                            </a></li>
                        <li><a href="#"
                                class="text-slate-400 hover:text-amber-500 transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Lihat Semua
                            </a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="lg:col-span-3">
                    <h4 class="text-white font-bold mb-4 text-lg">Hubungi Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div
                                class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-400">Jl. Contoh No. 123</p>
                                <p class="text-sm text-slate-400">Bandung, Jawa Barat</p>
                            </div>
                        </li>
                        <li class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-sm text-slate-400">(022) 123-4567</p>
                        </li>
                        <li class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-sm text-slate-400">booking@studiokami.com</p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-slate-800 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-slate-400 text-sm">© {{ date('Y') }} Studio Musik Premium. All rights reserved.
                    </p>
                    <div class="flex gap-6 text-sm">
                        <a href="#" class="text-slate-400 hover:text-amber-500 transition-colors">Syarat &
                            Ketentuan</a>
                        <a href="#" class="text-slate-400 hover:text-amber-500 transition-colors">Kebijakan
                            Privasi</a>
                        <a href="#" class="text-slate-400 hover:text-amber-500 transition-colors">FAQ</a>
                    </div>
                    <p class="text-slate-400 text-sm flex items-center">
                        Made with <span class="text-red-500 mx-1">❤️</span> in Bandung
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
