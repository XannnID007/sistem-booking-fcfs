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
        }

        .text-gold-600 {
            color: #CA8A04;
        }

        .navbar-link-active {
            color: #CA8A04;
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
            border-radius: 2px;
        }
    </style>
</head>

<body class="antialiased" x-data="{
    notifications: [],
    unreadCount: 0,
    async fetchNotifications() {
        try {
            const response = await fetch('/notifications');
            const data = await response.json();
            this.notifications = data.notifications || [];
            this.unreadCount = data.unread_count || 0;
        } catch (error) {
            console.error('Error fetching notifications:', error);
        }
    },
    async markAsRead(notificationId) {
        try {
            await fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Content-Type': 'application/json'
                }
            });
            await this.fetchNotifications();
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    }
}" x-init="fetchNotifications();
setInterval(() => fetchNotifications(), 30000)">

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

                <div class="flex items-center gap-3">
                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="relative p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            <span x-show="unreadCount > 0"
                                class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold"
                                x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-slate-200 overflow-hidden"
                            style="display: none;">

                            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-4 py-3">
                                <h3 class="text-white font-bold text-sm">Notifikasi</h3>
                                <p class="text-amber-100 text-xs" x-text="unreadCount + ' belum dibaca'"></p>
                            </div>

                            <div class="max-h-96 overflow-y-auto">
                                <template x-if="notifications.length === 0">
                                    <div class="p-8 text-center">
                                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p class="text-slate-500 text-sm">Tidak ada notifikasi</p>
                                    </div>
                                </template>

                                <template x-for="notification in notifications" :key="notification.id">
                                    <div @click="markAsRead(notification.id)"
                                        class="p-4 border-b border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors"
                                        :class="!notification.read_at ? 'bg-amber-50' : ''">
                                        <div class="flex items-start gap-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                                                :class="notification.type === 'payment' ? 'bg-green-100' : 'bg-blue-100'">
                                                <svg class="w-5 h-5"
                                                    :class="notification.type === 'payment' ? 'text-green-600' :
                                                        'text-blue-600'"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-slate-900"
                                                    x-text="notification.title"></p>
                                                <p class="text-xs text-slate-600 mt-1" x-text="notification.message">
                                                </p>
                                                <p class="text-xs text-slate-400 mt-1" x-text="notification.time"></p>
                                            </div>
                                            <div x-show="!notification.read_at"
                                                class="w-2 h-2 bg-amber-500 rounded-full flex-shrink-0 mt-2"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- User Dropdown -->
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
