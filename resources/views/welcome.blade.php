<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaniOptimal - Pendukung Cerdas Petani Padi Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="text-3xl">🌾</span>
                <h1 class="text-2xl font-bold gradient-text">TaniOptimal</h1>
            </div>
            <div class="flex space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-6">
                <h2 class="text-5xl font-bold text-gray-900">
                    Pertanian Padi Lebih <span class="gradient-text">Cerdas & Efisien</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Teknologi AI dan data real-time untuk membantu petani padi membuat keputusan yang lebih baik dan meningkatkan produktivitas.
                </p>
                <div class="flex space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                            Mulai Sekarang
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-8 py-3 bg-white border-2 border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition font-semibold">
                                Daftar Gratis
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Image -->
            <div class="bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg p-8 flex items-center justify-center">
                <div class="text-center space-y-4">
                    <div class="text-8xl">🌾</div>
                    <p class="text-lg text-gray-700 font-semibold">Platform Pertanian Padi Digital</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Utama -->
    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-4xl font-bold text-center mb-16 text-gray-900">
                Fitur Unggulan
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">📚</div>
                    <h4 class="text-xl font-bold mb-3 text-gray-900">Knowledge Base</h4>
                    <p class="text-gray-700">
                        5+ artikel lengkap tentang teknik pertanian padi, dari pembajakan hingga panen.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-8 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">🌤️</div>
                    <h4 class="text-xl font-bold mb-3 text-gray-900">Weather Forecast</h4>
                    <p class="text-gray-700">
                        Prakiraan cuaca 14 hari dengan rekomendasi otomatis untuk penanaman padi.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">💬</div>
                    <h4 class="text-xl font-bold mb-3 text-gray-900">AI Chatbot</h4>
                    <p class="text-gray-700">
                        Konsultasi 24/7 dengan ahli pertanian padi powered by OpenAI.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">📅</div>
                    <h4 class="text-xl font-bold mb-3 text-gray-900">Smart Scheduler</h4>
                    <p class="text-gray-700">
                        Manajemen jadwal tanam dengan rekomendasi cerdas berdasarkan cuaca.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Teknologi -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-4xl font-bold text-center mb-16 text-gray-900">
                Teknologi Modern
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-6xl mb-4">⚙️</div>
                    <h4 class="text-2xl font-bold mb-2">Backend: Laravel 11</h4>
                    <p class="text-gray-600">Framework PHP modern dengan Eloquent ORM</p>
                </div>
                <div class="text-center">
                    <div class="text-6xl mb-4">🎨</div>
                    <h4 class="text-2xl font-bold mb-2">Frontend: Vue.js 3</h4>
                    <p class="text-gray-600">Interactive UI dengan Tailwind CSS</p>
                </div>
                <div class="text-center">
                    <div class="text-6xl mb-4">🔌</div>
                    <h4 class="text-2xl font-bold mb-2">APIs: OpenWeather & OpenAI</h4>
                    <p class="text-gray-600">Integrasi dengan teknologi terkini</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik -->
    <section class="bg-green-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-5xl font-bold mb-2">5+</div>
                    <p class="text-lg">Artikel Pertanian</p>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">25+</div>
                    <p class="text-lg">API Endpoints</p>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">24/7</div>
                    <p class="text-lg">AI Support</p>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">100%</div>
                    <p class="text-lg">Production Ready</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-green-600 to-emerald-600 text-white py-16">
        <div class="max-w-4xl mx-auto px-6 text-center space-y-6">
            <h3 class="text-4xl font-bold">
                Siap Meningkatkan Produktivitas Pertanian Anda?
            </h3>
            <p class="text-xl">
                Bergabunglah dengan ribuan petani yang telah mempercayai PadiConnect
            </p>
            <div class="flex justify-center space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-white text-green-600 rounded-lg hover:bg-gray-100 transition font-semibold">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-white text-green-600 rounded-lg hover:bg-gray-100 transition font-semibold">
                        Login Sekarang
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-8 py-3 border-2 border-white text-white rounded-lg hover:bg-white hover:text-green-600 transition font-semibold">
                            Daftar Gratis
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="text-2xl">🌾</span>
                        <h5 class="text-xl font-bold text-white">PadiConnect</h5>
                    </div>
                    <p>Platform pendukung cerdas untuk petani padi Indonesia</p>
                </div>
                <div>
                    <h5 class="text-white font-bold mb-4">Fitur</h5>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition">Knowledge Base</a></li>
                        <li><a href="#" class="hover:text-white transition">Weather Forecast</a></li>
                        <li><a href="#" class="hover:text-white transition">AI Chatbot</a></li>
                        <li><a href="#" class="hover:text-white transition">Smart Scheduler</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-white font-bold mb-4">Dokumentasi</h5>
                    <ul class="space-y-2">
                        <li><a href="/QUICKSTART.md" class="hover:text-white transition">Quick Start</a></li>
                        <li><a href="/FEATURES.md" class="hover:text-white transition">Features</a></li>
                        <li><a href="/TESTING_GUIDE.md" class="hover:text-white transition">Testing</a></li>
                        <li><a href="/INSTALL.md" class="hover:text-white transition">Installation</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center">
                <p>&copy; 2025 PadiConnect. Semua hak dilindungi. Membangun pertanian padi yang lebih cerdas 🌾</p>
            </div>
        </div>
    </footer>
</body>
</html>
