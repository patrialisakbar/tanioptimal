<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TaniOptimal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Left Side - Hero (Hidden on Mobile) -->
        <div class="hidden md:flex md:w-1/2 gradient-bg text-white flex-col items-center justify-center p-12">
            <div class="text-center space-y-6">
                <div class="text-8xl mb-8">🌾</div>
                <h2 class="text-4xl font-bold">Bergabunglah dengan TaniOptimal</h2>
                <p class="text-xl opacity-90">Platform pendukung cerdas untuk petani padi modern</p>
                
                <div class="mt-12 space-y-4 text-left">
                    <div class="flex items-center space-x-3">
                        <div class="text-2xl">✅</div>
                        <span>Registrasi Gratis</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-2xl">⚡</div>
                        <span>Akses Instan ke Semua Fitur</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-2xl">🔒</div>
                        <span>Data Anda Aman</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-2xl">🌍</div>
                        <span>Komunitas Petani Global</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-6 overflow-y-auto">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center space-x-2 mb-4">
                        <span class="text-4xl">🌾</span>
                        <h1 class="text-3xl font-bold text-gray-900">TaniOptimal</h1>
                    </div>
                    <p class="text-gray-600">Buat akun baru Anda</p>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="Nama Anda"
                        >
                        @error('name')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="nama@contoh.com"
                        >
                        @error('email')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="••••••••"
                        >
                        @error('password')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="••••••••"
                        >
                        @error('password_confirmation')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms -->
                    <div class="flex items-start">
                        <input 
                            type="checkbox" 
                            id="terms" 
                            name="terms"
                            required
                            class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 mt-1"
                        >
                        <label for="terms" class="ms-2 text-sm text-gray-600">
                            Saya setuju dengan 
                            <a href="#" class="text-green-600 hover:text-green-700 font-medium">
                                Syarat & Ketentuan
                            </a>
                        </label>
                    </div>

                    <!-- Register Button -->
                    <button 
                        type="submit"
                        class="w-full gradient-bg text-white font-semibold py-3 rounded-lg hover:shadow-lg transition duration-300"
                    >
                        Daftar Sekarang
                    </button>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-gray-600 text-sm">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Info -->
                <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg text-center">
                    <p class="text-xs text-green-800">
                        🔒 Akun Anda akan diverifikasi dalam hitungan menit
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
