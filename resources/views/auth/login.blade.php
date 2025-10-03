<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Studio Musik Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #111827;
            /* gray-900 */
        }

        .text-gold-400 {
            color: #FBBF24;
        }

        .bg-gold-400 {
            background-color: #FBBF24;
        }

        .border-gold-400 {
            border-color: #FBBF24;
        }

        .ring-gold-400 {
            --tw-ring-color: #FBBF24;
        }

        .hover\:bg-gold-500:hover {
            background-color: #F59E0B;
        }

        .shadow-gold {
            box-shadow: 0 10px 15px -3px rgba(251, 191, 36, 0.1), 0 4px 6px -2px rgba(251, 191, 36, 0.05);
        }

        .glass-panel-dark {
            background: rgba(17, 24, 39, 0.6);
            /* Opacity dinaikkan sedikit untuk kontras */
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="text-slate-300">

    <a href="{{ route('welcome') }}"
        class="absolute top-6 left-6 z-50 flex items-center space-x-2 text-slate-300 hover:text-gold-400 transition-colors group">
        <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
            </path>
        </svg>
        <span class="text-sm font-semibold">Beranda</span>
    </a>

    <div class="relative min-h-screen flex items-center justify-center py-12 px-4">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('images/bg2.jpg') }}'); filter: blur(8px) brightness(0.4);"></div>

        <div class="relative w-full max-w-sm">
            <div class="glass-panel-dark rounded-2xl shadow-2xl p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-white">Selamat Datang</h1>
                    <p class="text-slate-400 text-sm mt-1">Masuk untuk melanjutkan.</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-900/50 border border-red-500/50 text-red-300 px-4 py-3 rounded-lg mb-6 text-sm">
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                class="w-full pl-11 pr-4 py-3 bg-gray-900/50 border border-slate-700 rounded-lg text-slate-200 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 transition"
                                placeholder="Email">
                        </div>
                    </div>

                    <div x-data="{ showPassword: false }">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </span>
                            <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required
                                class="w-full pl-11 pr-10 py-3 bg-gray-900/50 border border-slate-700 rounded-lg text-slate-200 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 transition"
                                placeholder="Password">
                            <button type-="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-500 hover:text-slate-300">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox"
                                class="h-4 w-4 bg-slate-800 border-slate-600 text-gold-400 focus:ring-gold-400 rounded">
                            <label for="remember" class="ml-2 block text-sm text-slate-400">Ingat saya</label>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 bg-gold-400 text-gray-900 rounded-lg font-bold hover:bg-gold-500 transition shadow-lg shadow-gold">
                            Masuk
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-slate-400">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-semibold text-gold-400 hover:underline">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
