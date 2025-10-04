<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-transition {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gradient-bg {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        }

        .nav-item {
            position: relative;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(to bottom, #fbbf24, #f59e0b);
            transform: scaleY(0);
            transition: transform 0.3s ease;
            border-radius: 0 4px 4px 0;
        }

        .nav-item:hover::before,
        .nav-item.active::before {
            transform: scaleY(1);
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(251, 191, 36, 0.15) 0%, rgba(251, 191, 36, 0.05) 100%);
            color: #fbbf24;
        }

        .nav-item:hover {
            background: rgba(148, 163, 184, 0.1);
        }
    </style>
</head>

<body class="bg-slate-50 antialiased" x-data="{
    sidebarOpen: true,
    notifications: [],
    unreadCount: 0,
    async fetchNotifications() {
        try {
            const response = await fetch('/admin/notifications');
            const data = await response.json();
            this.notifications = data.notifications || [];
            this.unreadCount = data.unread_count || 0;
        } catch (error) { console.error('Error:', error); }
    },
    async markAsRead(id) {
        try {
            await fetch(`/admin/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Content-Type': 'application/json'
                }
            });
            await this.fetchNotifications();
        } catch (error) { console.error('Error:', error); }
    }
}" x-init="fetchNotifications();
setInterval(() => fetchNotifications(), 30000)">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar (kode sidebar sama seperti sebelumnya) -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="sidebar-transition gradient-bg flex flex-col fixed h-full z-30 shadow-2xl">
            <div class="h-20 flex items-center justify-center border-b border-slate-700/30 px-4 bg-slate-900/30">
                <img x-show="sidebarOpen" src="{{ asset('images/logo.png') }}" alt="Logo"
                    class="h-24 w-auto object-contain brightness-0 invert" x-transition>
                <img x-show="!sidebarOpen" src="{{ asset('images/logo.png') }}" alt="Logo"
                    class="h-16 w-auto object-contain brightness-0 invert">
            </div>
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-slate-300 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3" x-transition>Dashboard</span>
                </a>
                <a href="{{ route('admin.studio.index') }}"
                    class="nav-item flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.studio.*') ? 'active' : 'text-slate-300 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3" x-transition>Kelola Studio</span>
                </a>
                <a href="{{ route('admin.booking.index') }}"
                    class="nav-item flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.booking.*') ? 'active' : 'text-slate-300 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3" x-transition>Kelola Booking</span>
                </a>
                <a href="{{ route('admin.payment.index') }}"
                    class="nav-item flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.payment.*') ? 'active' : 'text-slate-300 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3" x-transition>Verifikasi Pembayaran</span>
                </a>
                <a href="{{ route('admin.laporan.index') }}"
                    class="nav-item flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.laporan.*') ? 'active' : 'text-slate-300 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3" x-transition>Kelola Laporan</span>
                </a>
            </nav>
            <div class="p-3 border-t border-slate-700/30 bg-slate-900/30">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="w-full flex items-center justify-center px-3 py-2.5 bg-slate-800/50 hover:bg-slate-700/50 rounded-lg transition-colors text-slate-300 hover:text-white">
                    <svg x-show="sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                    <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <div :class="sidebarOpen ? 'ml-64' : 'ml-20'" class="flex-1 flex flex-col overflow-hidden main-transition">

            <!-- Navbar -->
            <header class="bg-white border-b border-slate-200 sticky top-0 z-20 shadow-sm">
                <div class="flex items-center justify-between h-16 px-6">
                    <div>
                        <h1 class="text-lg font-bold text-slate-800">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-xs text-slate-500">@yield('page-subtitle', 'Selamat datang kembali')</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ notifOpen: false }">
                            <button @click="notifOpen = !notifOpen"
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

                            <div x-show="notifOpen" @click.away="notifOpen = false" x-transition
                                class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-slate-200 overflow-hidden"
                                style="display: none;">
                                <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-4 py-3">
                                    <h3 class="text-white font-bold text-sm">Notifikasi</h3>
                                    <p class="text-amber-100 text-xs" x-text="unreadCount + ' belum dibaca'"></p>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <template x-if="notifications.length === 0">
                                        <div class="p-8 text-center">
                                            <p class="text-slate-500 text-sm">Tidak ada notifikasi</p>
                                        </div>
                                    </template>
                                    <template x-for="notif in notifications" :key="notif.id">
                                        <div @click="markAsRead(notif.id); notifOpen = false"
                                            class="p-4 border-b hover:bg-slate-50 cursor-pointer"
                                            :class="!notif.read_at ? 'bg-amber-50' : ''">
                                            <p class="text-sm font-semibold text-slate-900" x-text="notif.title"></p>
                                            <p class="text-xs text-slate-600 mt-1" x-text="notif.message"></p>
                                            <p class="text-xs text-slate-400 mt-1" x-text="notif.time"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- User -->
                        <div x-data="{ userOpen: false }" class="relative">
                            <button @click="userOpen = !userOpen"
                                class="flex items-center gap-2 p-1.5 hover:bg-slate-50 rounded-lg transition-colors">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center">
                                    <span
                                        class="text-white font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <div class="text-left hidden sm:block">
                                    <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500">Administrator</p>
                                </div>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="userOpen" @click.away="userOpen = false" x-transition
                                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-200 py-1"
                                style="display: none;">
                                <div class="px-4 py-3 border-b border-slate-100">
                                    <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <div class="py-1">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
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
            </header>

            <!-- Main -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div x-data="toastManager()" @toast.window="addToast($event.detail)"
        class="fixed top-20 right-4 z-[9999] space-y-3 pointer-events-none">

        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show" x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transform transition ease-in duration-200"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-full opacity-0"
                class="pointer-events-auto w-96 max-w-sm bg-white rounded-xl shadow-2xl border overflow-hidden"
                :class="{
                    'border-green-200': toast.type === 'success',
                    'border-red-200': toast.type === 'error',
                    'border-blue-200': toast.type === 'info',
                    'border-amber-200': toast.type === 'warning'
                }">

                <div class="p-4">
                    <div class="flex items-start gap-3">
                        <!-- Icon -->
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center"
                            :class="{
                                'bg-green-100': toast.type === 'success',
                                'bg-red-100': toast.type === 'error',
                                'bg-blue-100': toast.type === 'info',
                                'bg-amber-100': toast.type === 'warning'
                            }">
                            <svg x-show="toast.type === 'success'" class="w-6 h-6 text-green-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <svg x-show="toast.type === 'error'" class="w-6 h-6 text-red-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <svg x-show="toast.type === 'info'" class="w-6 h-6 text-blue-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <svg x-show="toast.type === 'warning'" class="w-6 h-6 text-amber-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-900" x-text="toast.title"></p>
                            <p class="text-xs text-slate-600 mt-1" x-text="toast.message"></p>
                            <a x-show="toast.url" :href="toast.url"
                                class="inline-block mt-2 text-xs font-semibold hover:underline"
                                :class="{
                                    'text-green-700': toast.type === 'success',
                                    'text-red-700': toast.type === 'error',
                                    'text-blue-700': toast.type === 'info',
                                    'text-amber-700': toast.type === 'warning'
                                }">
                                Lihat Detail →
                            </a>
                        </div>

                        <!-- Close Button -->
                        <button @click="removeToast(toast.id)"
                            class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-3 h-1 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full transition-all duration-100 rounded-full"
                            :class="{
                                'bg-green-500': toast.type === 'success',
                                'bg-red-500': toast.type === 'error',
                                'bg-blue-500': toast.type === 'info',
                                'bg-amber-500': toast.type === 'warning'
                            }"
                            :style="`width: ${toast.progress}%`"></div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <script>
        function toastManager() {
            return {
                toasts: [],
                nextId: 1,
                addToast(data) {
                    const toast = {
                        id: this.nextId++,
                        type: data.type || 'info',
                        title: data.title || 'Notifikasi',
                        message: data.message || '',
                        url: data.url || null,
                        show: false,
                        progress: 100,
                        duration: data.duration || 5000
                    };
                    this.toasts.push(toast);
                    setTimeout(() => {
                        const toastIndex = this.toasts.findIndex(t => t.id === toast.id);
                        if (toastIndex !== -1) this.toasts[toastIndex].show = true;
                    }, 100);
                    const interval = setInterval(() => {
                        const toastIndex = this.toasts.findIndex(t => t.id === toast.id);
                        if (toastIndex !== -1) {
                            this.toasts[toastIndex].progress -= 2;
                            if (this.toasts[toastIndex].progress <= 0) clearInterval(interval);
                        }
                    }, toast.duration / 50);
                    setTimeout(() => this.removeToast(toast.id), toast.duration);
                },
                removeToast(id) {
                    const index = this.toasts.findIndex(t => t.id === id);
                    if (index !== -1) {
                        this.toasts[index].show = false;
                        setTimeout(() => this.toasts.splice(index, 1), 300);
                    }
                }
            };
        }

        window.showToast = function(type, title, message, url = null, duration = 5000) {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: {
                    type,
                    title,
                    message,
                    url,
                    duration
                }
            }));
        };

        // Auto check new notifications and show toast
        document.addEventListener('alpine:init', () => {
            let lastNotificationId = localStorage.getItem('lastNotificationId') || 0;

            async function checkNewNotifications() {
                try {
                    const response = await fetch('/admin/notifications');
                    const data = await response.json();

                    if (data.notifications && data.notifications.length > 0) {
                        data.notifications.forEach(notif => {
                            if (notif.id > lastNotificationId && !notif.read_at) {
                                let toastType = 'info';
                                if (notif.type === 'payment') {
                                    if (notif.title.includes('Terverifikasi')) toastType = 'success';
                                    else if (notif.title.includes('Ditolak')) toastType = 'error';
                                    else toastType = 'warning';
                                } else if (notif.type === 'booking') {
                                    if (notif.title.includes('Selesai')) toastType = 'success';
                                    else if (notif.title.includes('Dibatalkan')) toastType = 'error';
                                    else toastType = 'info';
                                }
                                window.showToast(toastType, notif.title, notif.message, notif.url,
                                    6000);
                            }
                        });
                        if (data.notifications[0]) {
                            lastNotificationId = data.notifications[0].id;
                            localStorage.setItem('lastNotificationId', lastNotificationId);
                        }
                    }
                } catch (error) {
                    console.error('Error checking notifications:', error);
                }
            }

            checkNewNotifications();
            setInterval(checkNewNotifications, 10000);
        });

        // Show toast from Laravel session
        @if (session('success'))
            window.addEventListener('load', () => {
                window.showToast('success', 'Berhasil!', '{{ session('success') }}', null, 5000);
            });
        @endif

        @if (session('error'))
            window.addEventListener('load', () => {
                window.showToast('error', 'Error!', '{{ session('error') }}', null, 5000);
            });
        @endif

        @if (session('warning'))
            window.addEventListener('load', () => {
                window.showToast('warning', 'Perhatian!', '{{ session('warning') }}', null, 5000);
            });
        @endif

        @if (session('info'))
            window.addEventListener('load', () => {
                window.showToast('info', 'Info', '{{ session('info') }}', null, 5000);
            });
        @endif
    </script>

    @stack('scripts')
</body>

</html>
