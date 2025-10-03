<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer') - Studio Musik Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            /* slate-100 */
        }

        .text-gold-600 {
            color: #CA8A04;
        }

        .bg-gold-500 {
            background-color: #FBBF24;
        }

        .hover\:bg-gold-600:hover {
            background-color: #D97706;
        }

        /* Style untuk link navbar yang aktif */
        .navbar-link-active {
            color: #CA8A04;
            /* gold-600 */
            font-weight: 600;
            position: relative;
        }

        .navbar-link-active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 3px;
            background-color: #FBBF24;
            /* gold-500 */
            border-radius: 2px;
        }
    </style>
</head>

<body class="antialiased">

    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-slate-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('customer.home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-28 h-28 object-contain -my-4">
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('customer.home') }}"
                        class="relative text-sm font-medium transition-colors text-slate-700 hover:text-gold-600 {{ request()->routeIs('customer.home') ? 'navbar-link-active' : '' }}">Beranda</a>
                    <a href="{{ route('customer.studio.index') }}"
                        class="relative text-sm font-medium transition-colors text-slate-700 hover:text-gold-600 {{ request()->routeIs('customer.studio.*') ? 'navbar-link-active' : '' }}">Studio</a>
                    <a href="{{ route('customer.booking.index') }}"
                        class="relative text-sm font-medium transition-colors text-slate-700 hover:text-gold-600 {{ request()->routeIs('customer.booking.index') ? 'navbar-link-active' : '' }}">Booking
                        Saya</a>
                    <a href="{{ route('customer.booking.history') }}"
                        class="relative text-sm font-medium transition-colors text-slate-700 hover:text-gold-600 {{ request()->routeIs('customer.booking.history') ? 'navbar-link-active' : '' }}">Riwayat</a>
                </div>

                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen"
                        class="flex items-center space-x-2 focus:outline-none">
                        <span class="font-semibold text-sm text-slate-700">{{ auth()->user()->name }}</span>
                        <svg class="h-5 w-5 text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition
                        class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-slate-200 py-1 z-50"
                        style="display: none;">
                        <div class="px-4 py-3 border-b border-slate-100">
                            <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="py-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">...</svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-slate-500 text-sm">
                © {{ date('Y') }} Studio Musik Booking System. All rights reserved.
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
