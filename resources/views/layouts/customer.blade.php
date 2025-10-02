<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer') - Studio Musik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-slate-50">

    <!-- Fixed Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-gradient-to-r from-slate-900 to-teal-900 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-teal-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white hidden sm:block">Studio Musik</span>
                </div>

                <!-- Menu Navigation -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('customer.home') }}"
                        class="px-4 py-2 text-white hover:bg-white/10 rounded-lg transition {{ request()->routeIs('customer.home') ? 'bg-white/10' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('customer.studio.index') }}"
                        class="px-4 py-2 text-white hover:bg-white/10 rounded-lg transition {{ request()->routeIs('customer.studio.*') ? 'bg-white/10' : '' }}">
                        Studio
                    </a>
                    <a href="{{ route('customer.booking.index') }}"
                        class="px-4 py-2 text-white hover:bg-white/10 rounded-lg transition {{ request()->routeIs('customer.booking.index') ? 'bg-white/10' : '' }}">
                        Booking Saya
                    </a>
                    <a href="{{ route('customer.booking.history') }}"
                        class="px-4 py-2 text-white hover:bg-white/10 rounded-lg transition {{ request()->routeIs('customer.booking.history') ? 'bg-white/10' : '' }}">
                        Riwayat
                    </a>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-3">
                    <div class="relative group">
                        <button
                            class="flex items-center space-x-2 px-4 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-white text-sm hidden sm:block">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="py-2">
                                <div class="px-4 py-2 border-b">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden p-2 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-slate-800 border-t border-slate-700">
            <div class="px-4 py-3 space-y-2">
                <a href="{{ route('customer.home') }}"
                    class="block px-4 py-2 text-white hover:bg-white/10 rounded-lg {{ request()->routeIs('customer.home') ? 'bg-white/10' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('customer.studio.index') }}"
                    class="block px-4 py-2 text-white hover:bg-white/10 rounded-lg {{ request()->routeIs('customer.studio.*') ? 'bg-white/10' : '' }}">
                    Studio
                </a>
                <a href="{{ route('customer.booking.index') }}"
                    class="block px-4 py-2 text-white hover:bg-white/10 rounded-lg {{ request()->routeIs('customer.booking.index') ? 'bg-white/10' : '' }}">
                    Booking Saya
                </a>
                <a href="{{ route('customer.booking.history') }}"
                    class="block px-4 py-2 text-white hover:bg-white/10 rounded-lg {{ request()->routeIs('customer.booking.history') ? 'bg-white/10' : '' }}">
                    Riwayat
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16 min-h-screen">
        <!-- Alert Messages -->
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-400 text-sm">
                © 2025 Studio Musik Booking System. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[class*="border-green"], [class*="border-red"]');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>

</html>
