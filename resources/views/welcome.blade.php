<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Studio Musik - Modern & Mudah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .fixed-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: -1;
            background-image: url('{{ asset('images/bg1.jpg') }}');
            background-size: cover;
            background-position: center;
            filter: blur(4px) brightness(0.9);
        }

        .glass-panel-light {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 1);
        }

        /* Definisi Warna Emas */
        .text-gold-500 {
            color: #F59E0B;
        }

        .bg-gold-400 {
            background-color: #FBBF24;
        }

        .hover\:bg-gold-500:hover {
            background-color: #F59E0B;
        }

        .hover\:text-gold-500:hover {
            color: #F59E0B;
        }
    </style>
</head>

<body x-data="{ lastScrollY: window.scrollY, navbarVisible: true }"
    @scroll.window="
        const currentScrollY = window.scrollY;
        if (currentScrollY > lastScrollY && currentScrollY > 100) { navbarVisible = false; } 
        else { navbarVisible = true; }
        lastScrollY = currentScrollY;
    "
    class="text-slate-800">

    <div class="fixed-bg"></div>

    <nav :class="navbarVisible ? 'translate-y-0' : '-translate-y-full'"
        class="fixed w-full z-50 top-0 left-0 right-0 transition-transform duration-300 ease-in-out">
        <div class="max-w-6xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center glass-panel-light rounded-xl p-2 px-4 shadow-sm">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-24 h-24 object-contain -my-4">
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('login') }}"
                        class="px-5 py-2.5 text-slate-700 hover:text-gold-500 transition-colors font-semibold text-sm">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 bg-gold-400 text-gray-900 rounded-lg hover:bg-gold-500 transition-all font-semibold text-sm shadow-sm">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative z-10">
        <section class="h-screen w-full flex items-center justify-center p-4">
            <div class="text-center glass-panel-light rounded-3xl p-8 md:p-16 shadow-lg max-w-6xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 mb-4">
                    Ekspresikan Musikmu.<br>Kami <span class="text-gold-500">Urus</span> Sisanya.
                </h1>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto mb-8">
                    Platform booking studio paling modern. Temukan jadwal kosong, bayar, dan mainkan. Semudah itu.
                </p>
                <a href="{{ route('customer.studio.index') }}"
                    class="inline-block px-10 py-4 bg-gold-400 text-gray-900 rounded-lg hover:bg-gold-500 transition-all font-bold shadow-md transform hover:scale-105">
                    Mulai Booking
                </a>
            </div>
        </section>

        <div class="bg-white">
            <section class="py-20 px-4">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold text-slate-900 mb-4">Galeri Studio Kami</h2>
                        <p class="text-lg text-slate-500 max-w-2xl mx-auto">Intip fasilitas yang siap mendukung
                            kreativitasmu.</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="group aspect-w-1 aspect-h-1"><img
                                class="object-cover w-full h-full rounded-xl group-hover:scale-105 transition-transform duration-300"
                                src="{{ asset('images/bg1.jpg') }}" alt="Studio Image 1"></div>
                        <div class="group aspect-w-1 aspect-h-1"><img
                                class="object-cover w-full h-full rounded-xl group-hover:scale-105 transition-transform duration-300"
                                src="{{ asset('images/bg2.jpg') }}" alt="Studio Image 2"></div>
                        <div class="group aspect-w-1 aspect-h-1"><img
                                class="object-cover w-full h-full rounded-xl group-hover:scale-105 transition-transform duration-300"
                                src="{{ asset('images/bg3.jpg') }}" alt="Studio Image 3"></div>
                        <div class="group aspect-w-1 aspect-h-1"><img
                                class="object-cover w-full h-full rounded-xl group-hover:scale-105 transition-transform duration-300"
                                src="{{ asset('images/bg1.jpg') }}" alt="Studio Image 4"></div>
                    </div>
                </div>
            </section>
        </div>

        <section class="py-20 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-white mb-4 drop-shadow-lg">Kunjungi Kami</h2>
                    <p class="text-lg text-slate-200 drop-shadow-lg">Kami siap menyambut kedatanganmu.</p>
                </div>
                <div
                    class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center glass-panel-light p-8 rounded-2xl shadow-lg">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">Alamat Studio</h3>
                        <p class="text-slate-700 mb-2">Jl. Contoh No. 123, Kota Bandung, Jawa Barat 40111</p>
                        <p class="text-slate-600 mb-6">Lokasi strategis di pusat kota, mudah dijangkau dari mana saja.
                        </p>
                        <h4 class="text-lg font-semibold text-slate-900 mb-2">Jam Operasional:</h4>
                        <p class="text-slate-700">Senin - Minggu: 10:00 - 23:00 WIB</p>
                        <h4 class="text-lg font-semibold text-slate-900 mt-4 mb-2">Kontak:</h4>
                        <p class="text-slate-700">Telepon: (022) 123-4567</p>
                        <p class="text-slate-700">Email: booking@studiokami.com</p>
                    </div>
                    <div class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden border border-slate-200 shadow-lg">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.902348545229!2d107.61821037596045!3d-6.902206093096843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64c5e8866e5%3A0x34be56247c1f83c!2sGedung%20Sate!5e0!3m2!1sid!2sid!4v1696435368383!5m2!1sid!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-white pt-16 pb-6 px-2">
            <div class="max-w-3xl mx-auto text-center">
                <a href="#"><img src="{{ asset('images/logo.png') }}" alt="Logo"
                        class="w-34 h-32 object-contain mx-auto mt-4"></a>
                <p class="max-w-md mx-auto mt-2 text-slate-600">Platform booking studio musik modern yang dirancang
                    untuk memudahkan hidup para musisi.</p>
                <div class="flex justify-center space-x-6 mt-8">
                    <a href="#" class="text-slate-500 hover:text-gold-500 transition-colors">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.013-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.345 2.525c.636-.247 1.363-.416 2.427-.465C9.795 2.013 10.148 2 12.315 2zm0 1.62c-2.403 0-2.741.01-3.72.058-1.267.058-2.148.273-2.912.576a3.27 3.27 0 00-1.846 1.847c-.303.764-.518 1.644-.576 2.912C2.01 9.259 2 9.597 2 12.315s.01 3.056.058 4.035c.058 1.267.273 2.148.576 2.912a3.27 3.27 0 001.847 1.846c.764.303 1.644.518 2.912.576 1.02.048 1.317.058 3.72.058s2.699-.01 3.72-.058c1.267-.058 2.148-.273 2.912-.576a3.27 3.27 0 001.846-1.847c.303-.764.518-1.644.576-2.912.048-1.02.058-1.317.058-3.72s-.01-2.699-.058-3.72c-.058-1.267-.273-2.148-.576-2.912a3.27 3.27 0 00-1.846-1.847c-.764-.303-1.644-.518-2.912-.576C15.014 3.63 14.716 3.62 12.315 3.62zM12 8.118a4.197 4.197 0 100 8.394 4.197 4.197 0 000-8.394zm0 6.774a2.577 2.577 0 110-5.154 2.577 2.577 0 010 5.154zM16.803 8.11a.96.96 0 100-1.92.96.96 0 000 1.92z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-gold-500 transition-colors">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M19.702 4.298a4.805 4.805 0 00-1.66-1.12c-.93-.418-2.09-.7-3.41-.85C13.298 2.21 13.048 2 12 2s-.298.21-.632.328c-1.32.15-2.48.432-3.41.85a4.805 4.805 0 00-1.66 1.12c-.598.598-.996 1.378-1.12 2.203-.15 1.32-.21 2.82-.21 3.499s.06 2.178.21 3.499c.124.825.522 1.605 1.12 2.203.598.598 1.378.996 2.203 1.12 1.32.15 2.82.21 3.499.21s2.178-.06 3.499-.21c.825-.124 1.605-.522 2.203-1.12.598-.598.996-1.378 1.12-2.203.15-1.32.21-2.82.21-3.499s-.06-2.178-.21-3.499a4.805 4.805 0 00-1.12-2.203zM12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1.12-6.082c-.282 0-.51.228-.51.51v.153c0 .282.228.51.51.51h2.24c.282 0 .51-.228.51-.51v-.153c0-.282-.228-.51-.51-.51h-2.24zm4.18-3.033a.51.51 0 01-.362-.872c.443-.443.725-1.03.725-1.674 0-.644-.282-1.231-.725-1.674a2.352 2.352 0 00-1.674-.725c-.644 0-1.231.282-1.674.725a2.352 2.352 0 00-.725 1.674c0 .644.282 1.231.725 1.674a.51.51 0 01-.724.724 3.372 3.372 0 01-1.03-2.398c0-.93.383-1.79 1.03-2.398a3.372 3.372 0 012.398-1.03c.93 0 1.79.383 2.398 1.03.647.608 1.03 1.468 1.03 2.398 0 .93-.383 1.79-1.03 2.398a.51.51 0 01-.362.148zm-6.142 0a.51.51 0 01-.362-.872c.443-.443.725-1.03.725-1.674 0-.644-.282-1.231-.725-1.674a2.352 2.352 0 00-1.674-.725c-.644 0-1.231.282-1.674.725a2.352 2.352 0 00-.725 1.674c0 .644.282 1.231.725 1.674a.51.51 0 11-.724.724 3.372 3.372 0 01-1.03-2.398c0-.93.383-1.79 1.03-2.398.608-.647 1.468-1.03 2.398-1.03.93 0 1.79.383 2.398 1.03.647.608 1.03 1.468 1.03 2.398 0 .93-.383 1.79-1.03 2.398a.51.51 0 01-.362.148z" />
                        </svg>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-gold-500 transition-colors">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M11.944 12.062c-1.06 0-1.92.86-1.92 1.92s.86 1.92 1.92 1.92 1.92-.86 1.92-1.92-.86-1.92-1.92-1.92zm2.152 4.085c-.322 1.139-1.42 2.016-2.662 1.996-1.291-.02-2.378-.962-2.618-2.196-.233-1.196.536-2.436 1.732-2.669.04-.008.08-.016.12-.024.08-.016.15-.041.23-.058.07-.017.14-.042.21-.059.08-.018.15-.044.23-.061.08-.017.16-.034.24-.051.1-.02.19-.05.29-.071.09-.02.19-.04.28-.051l.1-.01.12-.01c.21-.02.42-.02.63 0l.12.01.1.01c.09.01.19.03.28.05.1.02.19.05.29.07.08.02.16.03.24.05.08.02.15.04.23.06.07.02.14.04.21.06.08.02.15.04.23.06.04.01.08.02.12.02 1.196.233 1.965 1.472 1.732 2.669zM12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z" />
                        </svg>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-gold-500 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="mt-12 border-t border-slate-200 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center text-sm text-slate-500">
                    <div class="flex space-x-6 order-2 md:order-1 mt-4 md:mt-0">
                        <a href="#" class="hover:text-gold-500 transition-colors">Syarat & Ketentuan</a>
                        <a href="#" class="hover:text-gold-500 transition-colors">Kebijakan Privasi</a>
                    </div>
                    <p class="order-1 md:order-2">© {{ date('Y') }} Studio Musik Booking System. All rights
                        reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
