<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Studio Musik Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-900">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-slate-900/90 backdrop-blur-lg border-b border-purple-800/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">Studio Musik</span>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}"
                        class="px-5 py-2 text-white hover:text-purple-300 transition font-medium">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition font-medium shadow-lg">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 px-4 overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/20 via-slate-900 to-indigo-900/20"></div>
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-600/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
                    Booking Studio Musik
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400">
                        Jadi Lebih Mudah
                    </span>
                </h1>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                    Sistem booking online dengan algoritma FCFS. Pesan studio musik favoritmu dengan mudah, cepat, dan
                    aman.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}"
                        class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition font-medium shadow-xl text-lg">
                        Mulai Booking Sekarang
                    </a>
                    <a href="#fitur"
                        class="px-8 py-3 bg-white/10 backdrop-blur text-white rounded-lg hover:bg-white/20 transition font-medium border border-white/20">
                        Lihat Fitur
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
                <div class="bg-white/5 backdrop-blur-lg rounded-xl p-6 border border-purple-500/20">
                    <div class="text-4xl font-bold text-purple-400 mb-2">24/7</div>
                    <div class="text-gray-300">Booking Kapan Saja</div>
                </div>
                <div class="bg-white/5 backdrop-blur-lg rounded-xl p-6 border border-indigo-500/20">
                    <div class="text-4xl font-bold text-indigo-400 mb-2">FCFS</div>
                    <div class="text-gray-300">Sistem Antrian Fair</div>
                </div>
                <div class="bg-white/5 backdrop-blur-lg rounded-xl p-6 border border-purple-500/20">
                    <div class="text-4xl font-bold text-purple-400 mb-2">QRIS</div>
                    <div class="text-gray-300">Pembayaran Mudah</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 px-4 bg-slate-800/50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-white mb-4">Fitur Unggulan</h2>
                <p class="text-gray-400">Kemudahan yang kami tawarkan untuk pengalaman booking terbaik</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="bg-gradient-to-br from-purple-900/40 to-slate-900/40 backdrop-blur-lg rounded-xl p-6 border border-purple-500/20 hover:border-purple-500/40 transition">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Booking Real-Time</h3>
                    <p class="text-gray-400">Cek ketersediaan studio secara real-time dan booking langsung</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="bg-gradient-to-br from-indigo-900/40 to-slate-900/40 backdrop-blur-lg rounded-xl p-6 border border-indigo-500/20 hover:border-indigo-500/40 transition">
                    <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Pembayaran QRIS</h3>
                    <p class="text-gray-400">Bayar dengan mudah menggunakan QRIS, aman dan cepat</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="bg-gradient-to-br from-purple-900/40 to-slate-900/40 backdrop-blur-lg rounded-xl p-6 border border-purple-500/20 hover:border-purple-500/40 transition">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Sistem FCFS</h3>
                    <p class="text-gray-400">First Come First Served - siapa cepat dia dapat</p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="bg-gradient-to-br from-indigo-900/40 to-slate-900/40 backdrop-blur-lg rounded-xl p-6 border border-indigo-500/20 hover:border-indigo-500/40 transition">
                    <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Riwayat Booking</h3>
                    <p class="text-gray-400">Lihat semua riwayat booking dan status pembayaran</p>
                </div>

                <!-- Feature 5 -->
                <div
                    class="bg-gradient-to-br from-purple-900/40 to-slate-900/40 backdrop-blur-lg rounded-xl p-6 border border-purple-500/20 hover:border-purple-500/40 transition">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Notifikasi Status</h3>
                    <p class="text-gray-400">Dapatkan update status booking secara real-time</p>
                </div>

                <!-- Feature 6 -->
                <div
                    class="bg-gradient-to-br from-indigo-900/40 to-slate-900/40 backdrop-blur-lg rounded-xl p-6 border border-indigo-500/20 hover:border-indigo-500/40 transition">
                    <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Laporan Digital</h3>
                    <p class="text-gray-400">Admin dapat export laporan ke Excel dan PDF</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div
                class="bg-gradient-to-r from-purple-900/50 to-indigo-900/50 backdrop-blur-lg rounded-2xl p-12 border border-purple-500/20">
                <h2 class="text-4xl font-bold text-white mb-4">Siap Mulai Booking?</h2>
                <p class="text-gray-300 mb-8 text-lg">
                    Daftar sekarang dan rasakan kemudahan booking studio musik dengan sistem FCFS
                </p>
                <a href="{{ route('register') }}"
                    class="inline-block px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition font-medium shadow-xl text-lg">
                    Daftar Gratis Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-purple-800/30 py-8 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray-400">© 2025 Studio Musik Booking System. All rights reserved.</p>
            <p class="text-gray-500 text-sm mt-2">Powered by FCFS Algorithm</p>
        </div>
    </footer>

</body>

</html>
