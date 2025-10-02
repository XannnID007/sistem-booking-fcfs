<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Studio Musik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="bg-gradient-to-br from-slate-900 via-teal-900 to-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo/Brand -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-teal-600 rounded-full mb-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                    </path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Studio Musik</h1>
            <p class="text-teal-300 text-sm">Sistem Booking Studio</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white/95 backdrop-blur rounded-xl shadow-2xl p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-5">Masuk ke Akun</h2>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <p class="text-sm">{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-5">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                    <label for="remember" class="ml-2 text-sm text-gray-700">Ingat saya</label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-2.5 rounded-lg font-medium hover:from-teal-700 hover:to-cyan-700 transition shadow-lg">
                    Masuk
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-5 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-teal-600 hover:text-teal-700 font-medium">Daftar
                        sekarang</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-teal-300 text-xs mt-6">
            © 2025 Studio Musik Booking System
        </p>
    </div>

</body>

</html>
