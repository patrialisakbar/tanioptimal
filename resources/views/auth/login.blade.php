<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TaniOptimal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Left Side - Form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center space-x-2 mb-4">
                        <span class="text-4xl">🌾</span>
                        <h1 class="text-3xl font-bold text-gray-900">TaniOptimal</h1>
                    </div>
                    <p class="text-gray-600">Masuk ke akun Anda</p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                    @csrf

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
                            autofocus
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

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember"
                            class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                        >
                        <label for="remember" class="ms-2 text-sm text-gray-600">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit"
                        class="w-full gradient-bg text-white font-semibold py-3 rounded-lg hover:shadow-lg transition duration-300"
                    >
                        Masuk
                    </button>

                    <!-- Forgot Password Link -->
                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                                Lupa password?
                            </a>
                        </div>
                    @endif

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-gray-600 text-sm">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-semibold">
                                Daftar di sini
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Demo Account Info -->
                <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-xs font-semibold text-blue-900 mb-2">📝 Akun Demo:</p>
                    <p class="text-xs text-blue-800"><strong>Email:</strong> test@example.com</p>
                    <p class="text-xs text-blue-800"><strong>Password:</strong> password</p>
                </div>
            </div>
        </div>

        <!-- Right Side - Hero (Hidden on Mobile) -->
        <div class="hidden md:flex md:w-1/2 gradient-bg text-white flex-col items-center justify-center p-12">
            <div class="text-center space-y-6">
                <div class="text-8xl mb-8">🌾</div>
                <h2 class="text-4xl font-bold">Pertanian Padi Lebih Cerdas</h2>
                <p class="text-xl opacity-90">Teknologi AI dan data real-time untuk petani padi Indonesia</p>
                
                <div class="mt-12 space-y-4 text-left">
                    <div class="flex items-center space-x-3">
                        <div class="text-2xl">📚</div>
                        <span>Knowledge Base Lengkap</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-2xl">🌾</div>
                        <span>Prakiraan Cuaca Real-time</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-2xl">📅</div>
                        <span>Smart Planting Scheduler</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
