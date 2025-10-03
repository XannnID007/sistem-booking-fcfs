<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <title>@yield('title', 'Admin') - Studio Musik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-link-active {
            background-color: #f59e0b;
            /* amber-500 */
            color: #ffffff;
        }

        .sidebar-link-active svg {
            color: #ffffff;
        }
    </style>
</head>

<body class="bg-slate-100 antialiased">

    <div class="flex h-screen bg-slate-100">
        <aside class="w-64 flex-shrink-0 bg-slate-800 text-slate-300 flex flex-col">
            <div class="h-20 flex items-center justify-center border-b border-slate-700">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-32 object-contain">
            </div>
            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.studio.index') }}"
                    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition text-sm font-medium {{ request()->routeIs('admin.studio.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <span>Kelola Studio</span>
                </a>
                <a href="{{ route('admin.booking.index') }}"
                    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition text-sm font-medium {{ request()->routeIs('admin.booking.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>Data Booking</span>
                </a>
                <a href="{{ route('admin.payment.index') }}"
                    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition text-sm font-medium {{ request()->routeIs('admin.payment.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    <span>Verifikasi Pembayaran</span>
                </a>
                <a href="{{ route('admin.laporan.index') }}"
                    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-slate-700 hover:text-white transition text-sm font-medium {{ request()->routeIs('admin.laporan.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span>Laporan</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b border-slate-200">
                <div class="flex items-center justify-between h-20 px-6">
                    <div>
                        <h1 class="text-xl font-bold text-slate-800">@yield('page-title', 'Admin Panel')</h1>
                        <p class="text-sm text-slate-500">@yield('page-subtitle', 'Selamat datang!')</p>
                    </div>
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="flex items-center space-x-3 focus:outline-none p-2 rounded-lg hover:bg-slate-100 transition-colors">
                            <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500">Administrator</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7 7"></path>
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
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                        {{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
