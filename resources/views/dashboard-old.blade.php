<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TaniOptimal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f9fafb;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
            min-height: 100vh;
        }

        .tab-button {
            position: relative;
            padding: 12px 20px;
            border: none;
            background: transparent;
            color: #6b7280;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .tab-button.active {
            color: #10b981;
        }

        .tab-button.active::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #10b981, #059669);
            border-radius: 2px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                width: 0;
                left: 50%;
            }
            to {
                width: 100%;
                left: 0;
            }
        }

        .article-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .article-card:hover {
            border-color: #10b981;
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.1);
        }

        .article-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .article-card:hover .article-image {
            transform: scale(1.05);
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-tips {
            background: #dcfce7;
            color: #166534;
        }

        .badge-news {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-tutorial {
            background: #fed7aa;
            color: #92400e;
        }

        .badge-review {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .input-field {
            background: white;
            border: 1px solid #d1d5db;
            color: #1f2937;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            background: white;
        }

        .input-field::placeholder {
            color: #9ca3af;
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .welcome-banner {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 12px;
            padding: 40px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
            color: white;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent);
            border-radius: 50%;
        }

        .welcome-banner h2 {
            position: relative;
            z-index: 1;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-banner p {
            position: relative;
            z-index: 1;
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .card-section {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .stat-card:hover {
            border-color: #10b981;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
        }

        .stat-card h3 {
            font-size: 32px;
            font-weight: bold;
            color: #10b981;
            margin: 10px 0;
        }

        .stat-card p {
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Navigation Bar -->
    <nav class="navbar sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center text-white text-2xl shadow-md">
                    🌾
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">TaniOptimal</h1>
                    <p class="text-xs text-gray-500">Smart Farming Platform</p>
                </div>
            </div>
            <div class="flex items-center space-x-6">
                <div class="text-right hidden sm:block">
                    <p class="text-sm text-gray-700">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">Petani</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Welcome Section -->
        <div class="welcome-banner">
            <h2>Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
            <p>Kelola pertanian padi Anda dengan solusi teknologi terkini dan rekomendasi berbasis AI</p>
        </div>

        <!-- Tabs Container -->
        <div class="card-section">
            <!-- Tab Navigation -->
            <div class="flex space-x-2 border-b border-gray-700 mb-8 pb-4 flex-wrap overflow-x-auto">
                <button onclick="switchTab('articles')" class="tab-button active" id="tab-articles">
                    <i class="fas fa-book mr-2"></i>Artikel
                </button>
                <button onclick="switchTab('weather')" class="tab-button" id="tab-weather">
                    <i class="fas fa-cloud-sun mr-2"></i>Cuaca
                </button>
                <button onclick="switchTab('rice')" class="tab-button" id="tab-rice">
                    <i class="fas fa-leaf mr-2"></i>Varietas Padi
                </button>
                <button onclick="switchTab('chat')" class="tab-button" id="tab-chat">
                    <i class="fas fa-comments mr-2"></i>Chat AI
                </button>
                <button onclick="switchTab('schedule')" class="tab-button" id="tab-schedule">
                    <i class="fas fa-calendar mr-2"></i>Jadwal
                </button>
            </div>

            <!-- TAB 1: ARTICLES -->
            <div id="articles-tab" class="tab-content fade-in">
                <!-- Search & Filter -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-4 text-gray-500"></i>
                        <input 
                            type="text" 
                            placeholder="Cari artikel..." 
                            id="articleSearch"
                            class="input-field w-full pl-10"
                        >
                    </div>
                    <select id="categoryFilter" class="input-field">
                        <option value="">Semua Kategori</option>
                        <option value="tips">Tips & Trik</option>
                        <option value="news">Berita</option>
                        <option value="tutorial">Tutorial</option>
                        <option value="review">Review</option>
                    </select>
                </div>

                <!-- Articles Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="articlesContainer">
                    <!-- Articles will be loaded here by JavaScript -->
                    <div class="col-span-3 text-center py-12">
                        <div class="loading-spinner mx-auto mb-4"></div>
                        <p class="text-gray-400">Memuat artikel...</p>
                    </div>
                </div>
            </div>

            <!-- TAB 2: WEATHER -->
            <div id="weather-tab" class="tab-content hidden">
                <!-- Loading Spinner -->
                <div id="weatherLoading" class="hidden text-center py-8">
                    <div class="inline-block animate-spin">
                        <div class="w-12 h-12 border-4 border-gray-200 border-t-green-600 rounded-full"></div>
                    </div>
                    <p class="text-gray-600 mt-4">Mengambil data cuaca...</p>
                </div>

                <!-- Weather Content -->
                <div id="weatherContent">
                    <!-- Location Selector -->
                    <div class="mb-6 flex gap-3">
                        <div class="flex-1 relative">
                            <select id="locationSelect" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-green-500 outline-none appearance-none bg-white cursor-pointer">
                                <option value="">🌾 Pilih Lokasi Pertanian</option>
                            </select>
                            <div class="pointer-events-none absolute right-3 top-3.5 text-gray-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </div>
                        </div>
                        <button onclick="getWeatherForecast()" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold whitespace-nowrap">
                            🔄 Get Forecast
                        </button>
                    </div>

                    <!-- Weather Info Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Suitability Score -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 border-l-4 border-green-600 rounded-lg p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">🎯 Suitability Score</h4>
                            <p class="text-5xl font-bold text-green-600 mb-2"><span id="suitabilityScore">--</span><span class="text-2xl">/100</span></p>
                            <p class="text-sm text-gray-700 bg-green-200 px-3 py-2 rounded-lg font-semibold text-center" id="suitabilityLabel">Loading...</p>
                        </div>

                        <!-- Temperature -->
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 border-l-4 border-orange-600 rounded-lg p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">🌡️ Temperature</h4>
                            <p class="text-5xl font-bold text-orange-600 mb-2"><span id="currentTemp">--</span>°C</p>
                            <p class="text-sm text-gray-700">Optimal: <span class="font-semibold text-green-600">20-30°C</span></p>
                        </div>



                        <!-- Humidity -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-l-4 border-blue-600 rounded-lg p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">💧 Humidity</h4>
                            <p class="text-5xl font-bold text-blue-600 mb-2"><span id="currentHumidity">--</span>%</p>
                            <p class="text-sm text-gray-700">Optimal: <span class="font-semibold text-green-600">60-80%</span></p>
                        </div>
                    </div>

                    <!-- Weather Error Message -->
                    <div id="weatherError" class="hidden mb-6 p-4 bg-red-100 border-l-4 border-red-600 rounded-lg">
                        <p class="text-red-800 font-semibold">Error</p>
                        <p class="text-red-700 text-sm" id="weatherErrorMsg"></p>
                    </div>

                    <!-- Forecast -->
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-6">📅 5-Day Forecast</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-300 px-4 py-3 text-left">Date</th>
                                        <th class="border border-gray-300 px-4 py-3 text-center">Weather</th>
                                        <th class="border border-gray-300 px-4 py-3 text-center">Temp</th>
                                        <th class="border border-gray-300 px-4 py-3 text-center">Humidity</th>
                                        <th class="border border-gray-300 px-4 py-3 text-center">Rainfall</th>
                                    </tr>
                                </thead>
                                <tbody id="forecastTableBody">
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-3" colspan="5" style="text-align: center; padding: 20px;">
                                            Pilih lokasi untuk melihat forecast
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: RICE VARIETY RECOMMENDATIONS -->
            <div id="rice-tab" class="tab-content hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Input Form -->
                    <div class="bg-white rounded-lg border-2 border-green-200 p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">🌾 Rekomendasi Varietas Padi</h3>
                        
                        <div class="space-y-4">
                            <!-- Jenis Tanah -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Tanah</label>
                                <select id="soilType" class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-green-500 focus:outline-none">
                                    <option value="">-- Pilih --</option>
                                    <option value="aluvial">Aluvial</option>
                                    <option value="liat">Liat</option>
                                    <option value="ultisol">Ultisol</option>
                                    <option value="gambut">Gambut</option>
                                    <option value="rawa">Rawa</option>
                                </select>
                            </div>

                            <!-- Curah Hujan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Curah Hujan</label>
                                <select id="rainfallCategory" class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-green-500 focus:outline-none">
                                    <option value="">-- Pilih --</option>
                                    <option value="rawan_kekeringan">Rawan Kekeringan</option>
                                    <option value="sedang">Sedang</option>
                                    <option value="rawan_banjir">Rawan Banjir</option>
                                </select>
                            </div>

                            <!-- Suhu Optimal -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Suhu Optimal</label>
                                <select id="temperatureOptimal" class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-green-500 focus:outline-none">
                                    <option value="">-- Pilih --</option>
                                    <option value="dingin">Dingin</option>
                                    <option value="sedang">Sedang</option>
                                    <option value="panas">Panas</option>
                                </select>
                            </div>

                            <!-- Ketinggian Lahan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Ketinggian Lahan</label>
                                <select id="elevationCategory" class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-green-500 focus:outline-none">
                                    <option value="">-- Pilih --</option>
                                    <option value="dataran_rendah">Dataran Rendah</option>
                                    <option value="dataran_menengah">Dataran Menengah</option>
                                    <option value="dataran_tinggi">Dataran Tinggi</option>
                                </select>
                            </div>

                            <!-- Ketersediaan Air -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Ketersediaan Air</label>
                                <select id="waterAvailability" class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-green-500 focus:outline-none">
                                    <option value="">-- Pilih --</option>
                                    <option value="irigasi_teknis">Irigasi Teknis</option>
                                    <option value="tadah_hujan">Tadah Hujan</option>
                                    <option value="lahan_kering">Lahan Kering</option>
                                    <option value="rawa">Rawa</option>
                                </select>
                            </div>

                            <!-- Salinitas -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Salinitas</label>
                                <select id="salinityCategory" class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-green-500 focus:outline-none">
                                    <option value="">-- Pilih --</option>
                                    <option value="normal">Normal</option>
                                    <option value="air_payau">Air Payau</option>
                                    <option value="tinggi">Tinggi</option>
                                </select>
                            </div>

                            <!-- Ancaman -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Ancaman</label>
                                <select id="threats" class="w-full border-2 border-gray-300 rounded-lg p-2 focus:border-green-500 focus:outline-none">
                                    <option value="">-- Pilih --</option>
                                    <option value="rawan_banjir">Rawan Banjir</option>
                                    <option value="rawan_kekeringan">Rawan Kekeringan</option>
                                    <option value="rawan_angin_kencang">Rawan Angin Kencang</option>
                                    <option value="rawan_hama">Rawan Hama</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button onclick="getRiceRecommendations()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-lg transition">
                                🔍 Cari Rekomendasi
                            </button>
                        </div>
                    </div>

                    <!-- Results -->
                    <div class="space-y-4" id="riceResults">
                        <div class="bg-gray-100 rounded-lg p-8 text-center text-gray-600">
                            <p>Pilih parameter dan klik "Cari Rekomendasi"</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: AI CHAT -->
            <div id="chat-tab" class="tab-content hidden">
                <div class="flex gap-4 mb-6 border-b pb-4">
                    <button onclick="switchChatMode('chat')" class="pb-2 font-semibold text-green-600 border-b-2 border-green-600" id="chat-mode">
                        💬 Live Chat
                    </button>
                    <button onclick="switchChatMode('faq')" class="pb-2 font-semibold text-gray-600" id="faq-mode">
                        ❓ FAQ
                    </button>
                </div>

                <!-- Chat Mode -->
                <div id="chat-mode-content">
                    <div class="bg-gray-100 rounded-lg p-4 h-80 overflow-y-auto mb-6 border-2 border-gray-300 space-y-4">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center text-white text-sm">🤖</div>
                            <div class="bg-white rounded-lg p-3 max-w-xs">
                                <p class="text-sm">Halo! Saya asisten AI PadiConnect. Siap membantu pertanyaan Anda tentang pertanian padi! 😊</p>
                            </div>
                        </div>

                        <div class="flex gap-3 justify-end">
                            <div class="bg-green-600 text-white rounded-lg p-3 max-w-xs">
                                <p class="text-sm">Bagaimana cara mengatasi wereng?</p>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm flex-shrink-0">👤</div>
                        </div>

                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center text-white text-sm">🤖</div>
                            <div class="bg-white rounded-lg p-3 max-w-sm">
                                <p class="text-sm"><strong>Solusi Pengatasan Wereng:</strong></p>
                                <ul class="text-sm mt-2 ml-4 list-disc space-y-1">
                                    <li>Gunakan pestisida organik (ekstrak bawang)</li>
                                    <li>Lakukan rotasi tanaman yang tepat</li>
                                    <li>Jaga kelembaban optimal (60-80%)</li>
                                    <li>Manfaatkan predator alami wereng</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <input 
                            type="text" 
                            id="chatInput" 
                            placeholder="Tanya sesuatu tentang pertanian padi..." 
                            class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-green-500 outline-none"
                        >
                        <button onclick="sendMessage()" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                            Kirim
                        </button>
                    </div>
                </div>

                <!-- FAQ Mode -->
                <div id="faq-mode-content" class="hidden space-y-4">
                    <div class="bg-green-50 border-l-4 border-green-600 rounded-lg p-6">
                        <h4 class="font-bold text-gray-900 mb-2">❓ Kapan waktu terbaik untuk menanam?</h4>
                        <p class="text-gray-700 text-sm">November-Desember adalah waktu terbaik saat musim hujan. Suhu ideal 20-30°C dengan kelembaban 60-80%.</p>
                    </div>
                    <div class="bg-green-50 border-l-4 border-green-600 rounded-lg p-6">
                        <h4 class="font-bold text-gray-900 mb-2">❓ Berapa lama padi siap dipanen?</h4>
                        <p class="text-gray-700 text-sm">Padi siap dipanen setelah 120-150 hari sejak penanaman, tergantung varietas dan kondisi iklim.</p>
                    </div>
                    <div class="bg-green-50 border-l-4 border-green-600 rounded-lg p-6">
                        <h4 class="font-bold text-gray-900 mb-2">❓ Hama padi yang paling berbahaya?</h4>
                        <p class="text-gray-700 text-sm">Wereng coklat, wereng hijau, penggerek batang, dan walang sangit adalah hama berbahaya. Pengendalian dini sangat penting.</p>
                    </div>
                </div>
            </div>

            <!-- TAB 5: SCHEDULES -->
            <div id="schedule-tab" class="tab-content hidden">
                <!-- Add Schedule Form -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 mb-8 border-l-4 border-green-600">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">➕ Buat Jadwal Tanam Baru</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <input type="text" placeholder="Nama Lokasi" class="px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-green-500 outline-none">
                        <input type="text" placeholder="Varietas Padi" class="px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-green-500 outline-none">
                        <input type="date" class="px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-green-500 outline-none">
                        <button class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                            ➕ Buat
                        </button>
                    </div>
                </div>

                <!-- Active Schedule -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">📋 Jadwal Aktif</h3>
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-600 rounded-lg p-8">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h4 class="text-2xl font-bold text-gray-900">Padi Ciherang - Subang</h4>
                                <p class="text-gray-600">📍 Subang, Jawa Barat</p>
                            </div>
                            <span class="bg-green-200 text-green-800 px-4 py-2 rounded-full font-semibold text-sm">🟢 Planned</span>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 bg-white rounded-lg p-6 mb-6">
                            <div>
                                <p class="text-xs text-gray-600 font-semibold">📌 TANAM</p>
                                <p class="text-2xl font-bold text-green-600">26 Nov</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 font-semibold">🌾 PANEN</p>
                                <p class="text-2xl font-bold text-green-600">30 Mar</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 font-semibold">📏 LUAS</p>
                                <p class="text-2xl font-bold text-green-600">2.5 ha</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 font-semibold">⏳ UMUR</p>
                                <p class="text-2xl font-bold text-green-600">123 hari</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-6">
                            <p class="font-bold text-gray-900 mb-4">✓ Pre-Planting Tasks:</p>
                            <ul class="space-y-3 text-gray-700">
                                <li>✓ Siapkan benih unggul (21 hari sebelum tanam)</li>
                                <li>✓ Bajak lahan secara menyeluruh (14 hari)</li>
                                <li>✓ Siapkan sistem irigasi (7 hari)</li>
                                <li>• Beli pupuk dan pestisida (3 hari)</li>
                                <li>• Rekrutmen tenaga kerja (2 hari)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load articles from API
        async function loadArticles() {
            try {
                const category = document.getElementById('categoryFilter').value;
                const search = document.getElementById('articleSearch').value;
                
                let url = '/api/articles';
                const params = new URLSearchParams();
                
                if (category) params.append('category', category);
                if (search) params.append('search', search);
                
                if (params.toString()) {
                    url += '?' + params.toString();
                }
                
                const response = await fetch(url);
                const data = await response.json();
                
                const container = document.getElementById('articlesContainer');
                
                if (!data.data || data.data.length === 0) {
                    container.innerHTML = '<div class="col-span-3 text-center py-12"><i class="fas fa-inbox text-4xl text-gray-600 mb-4 block"></i><p class="text-gray-400">Belum ada artikel tersedia</p></div>';
                    return;
                }
                
                const categoryColors = {
                    'tips': { badge: 'badge-tips', label: 'Tips & Trik', icon: '💡' },
                    'news': { badge: 'badge-news', label: 'Berita', icon: '📰' },
                    'tutorial': { badge: 'badge-tutorial', label: 'Tutorial', icon: '📖' },
                    'review': { badge: 'badge-review', label: 'Review', icon: '⭐' }
                };
                
                container.innerHTML = data.data.map(article => {
                    const colors = categoryColors[article.category] || categoryColors['tips'];
                    
                    const imageUrl = article.featured_image 
                        ? `/storage/${article.featured_image.includes('articles/') ? article.featured_image : 'articles/' + article.featured_image}` 
                        : 'https://via.placeholder.com/400x200?text=TaniOptimal';
                    
                    const articleLink = article.link || '#';
                    const shortContent = article.content.replace(/<[^>]*>/g, '').substring(0, 120);
                    
                    return `
                        <div class="article-card card-hover">
                            <div class="relative overflow-hidden bg-gray-900 h-48">
                                <img src="${imageUrl}" alt="${article.title}" class="article-image w-full h-full">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <span class="${colors.badge} absolute top-4 right-4">${colors.label}</span>
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-white mb-3 line-clamp-2">${colors.icon} ${article.title}</h3>
                                <p class="text-gray-400 text-sm mb-4 line-clamp-2">${shortContent}...</p>
                                <div class="flex items-center justify-between pt-4 border-t border-gray-700">
                                    <div class="flex items-center space-x-2 text-xs text-gray-500">
                                        <i class="fas fa-eye"></i>
                                        <span>${article.views || 0} views</span>
                                    </div>
                                    <a href="${articleLink}" target="${article.link ? '_blank' : '_self'}" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white text-sm font-semibold rounded-lg transition">
                                        Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            } catch (error) {
                console.error('Error loading articles:', error);
                document.getElementById('articlesContainer').innerHTML = '<div class="col-span-3 text-center py-12"><i class="fas fa-exclamation-circle text-4xl text-red-500 mb-4 block"></i><p class="text-red-400">Gagal memuat artikel. Silakan refresh halaman.</p></div>';
            }
        }

        function switchTab(tabName) {
            // Hide all tabs and remove fade-in
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
                tab.classList.remove('fade-in');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            const selectedTab = document.getElementById(tabName + '-tab');
            selectedTab.classList.remove('hidden');
            selectedTab.classList.add('fade-in');
            document.getElementById('tab-' + tabName).classList.add('active');
            
            // Load articles when articles tab is clicked
            if (tabName === 'articles') {
                loadArticles();
            }
        }

        function switchChatMode(mode) {
            const chatContent = document.getElementById('chat-mode-content');
            const faqContent = document.getElementById('faq-mode-content');
            const chatBtn = document.getElementById('chat-mode');
            const faqBtn = document.getElementById('faq-mode');

            if (mode === 'chat') {
                chatContent.classList.remove('hidden');
                faqContent.classList.add('hidden');
                chatBtn.classList.add('border-b-2', 'border-green-600', 'text-green-600');
                chatBtn.classList.remove('text-gray-600');
                faqBtn.classList.remove('border-b-2', 'border-green-600', 'text-green-600');
                faqBtn.classList.add('text-gray-600');
            } else {
                faqContent.classList.remove('hidden');
                chatContent.classList.add('hidden');
                faqBtn.classList.add('border-b-2', 'border-green-600', 'text-green-600');
                faqBtn.classList.remove('text-gray-600');
                chatBtn.classList.remove('border-b-2', 'border-green-600', 'text-green-600');
                chatBtn.classList.add('text-gray-600');
            }
        }

        function sendMessage() {
            const input = document.getElementById('chatInput');
            if (input.value.trim()) {
                console.log('Message sent:', input.value);
                input.value = '';
            }
        }

        function getWeatherForecast() {
            const locationSelect = document.getElementById('locationSelect');
            const selectedValue = locationSelect.value;
            
            if (!selectedValue) {
                alert('Silakan pilih lokasi terlebih dahulu');
                return;
            }

            // Get location data from the stored locations object
            const location = window.locationsData.find(loc => loc.name === selectedValue);
            
            if (!location) {
                alert('Lokasi tidak ditemukan');
                return;
            }

            // Show loading
            document.getElementById('weatherLoading').classList.remove('hidden');
            document.getElementById('weatherError').classList.add('hidden');

            // Fetch weather data
            fetch(`/api/weather/data?latitude=${location.latitude}&longitude=${location.longitude}&location=${location.name}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('weatherLoading').classList.add('hidden');
                    
                    if (data.success) {
                        updateWeatherDisplay(data);
                    } else {
                        showWeatherError(data.error || 'Failed to fetch weather data');
                    }
                })
                .catch(error => {
                    document.getElementById('weatherLoading').classList.add('hidden');
                    showWeatherError(error.message);
                });
        }

        function updateWeatherDisplay(data) {
            const current = data.current;
            
            // Update current weather
            document.getElementById('currentTemp').textContent = current.temperature;
            document.getElementById('currentHumidity').textContent = current.humidity;
            document.getElementById('suitabilityScore').textContent = current.suitability_score;
            
            // Update suitability label with color
            const label = document.getElementById('suitabilityLabel');
            label.textContent = current.suitability_label.toUpperCase();
            
            if (current.suitability_score >= 80) {
                label.className = 'text-sm text-gray-700 bg-green-200 px-3 py-2 rounded-lg font-semibold text-center';
                label.textContent = '✅ EXCELLENT - ' + current.suitability_label.toUpperCase();
            } else if (current.suitability_score >= 60) {
                label.className = 'text-sm text-gray-700 bg-yellow-200 px-3 py-2 rounded-lg font-semibold text-center';
                label.textContent = '⚠️ GOOD - ' + current.suitability_label.toUpperCase();
            } else if (current.suitability_score >= 40) {
                label.className = 'text-sm text-gray-700 bg-orange-200 px-3 py-2 rounded-lg font-semibold text-center';
                label.textContent = '⚠️ FAIR - ' + current.suitability_label.toUpperCase();
            } else {
                label.className = 'text-sm text-gray-700 bg-red-200 px-3 py-2 rounded-lg font-semibold text-center';
                label.textContent = '❌ POOR - ' + current.suitability_label.toUpperCase();
            }

            // Update forecast table
            const tbody = document.getElementById('forecastTableBody');
            tbody.innerHTML = '';

            data.forecast.forEach(day => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="border border-gray-300 px-4 py-3">${day.date}</td>
                    <td class="border border-gray-300 px-4 py-3 text-center text-2xl">${day.icon}</td>
                    <td class="border border-gray-300 px-4 py-3 text-center font-semibold">${day.temperature}°C</td>
                    <td class="border border-gray-300 px-4 py-3 text-center">${day.humidity}%</td>
                    <td class="border border-gray-300 px-4 py-3 text-center">${day.rainfall.toFixed(1)} mm</td>
                `;
                tbody.appendChild(row);
            });
        }

        function showWeatherError(message) {
            document.getElementById('weatherError').classList.remove('hidden');
            document.getElementById('weatherErrorMsg').textContent = message;
        }

        // Fallback locations data if API fails
        const fallbackLocations = [
            // JAWA BARAT
            { name: 'Subang', province: 'Jawa Barat', latitude: -6.5653, longitude: 107.7756, emoji: '🌾' },
            { name: 'Indramayu', province: 'Jawa Barat', latitude: -6.3043, longitude: 108.3254, emoji: '🌾' },
            { name: 'Cirebon', province: 'Jawa Barat', latitude: -6.7038, longitude: 108.4738, emoji: '🌾' },
            { name: 'Bandung', province: 'Jawa Barat', latitude: -6.9147, longitude: 107.6098, emoji: '🌾' },
            { name: 'Ciamis', province: 'Jawa Barat', latitude: -7.3500, longitude: 107.3833, emoji: '🌾' },
            // JAWA TENGAH
            { name: 'Pemalang', province: 'Jawa Tengah', latitude: -7.0667, longitude: 109.3833, emoji: '🌾' },
            { name: 'Pekalongan', province: 'Jawa Tengah', latitude: -6.8869, longitude: 109.6748, emoji: '🌾' },
            { name: 'Demak', province: 'Jawa Tengah', latitude: -6.8955, longitude: 110.6364, emoji: '🌾' },
            { name: 'Sragen', province: 'Jawa Tengah', latitude: -7.4405, longitude: 110.9952, emoji: '🌾' },
            { name: 'Kudus', province: 'Jawa Tengah', latitude: -6.9063, longitude: 110.8381, emoji: '🌾' },
            { name: 'Rembang', province: 'Jawa Tengah', latitude: -6.7250, longitude: 111.2983, emoji: '🌾' },
            { name: 'Semarang', province: 'Jawa Tengah', latitude: -6.9667, longitude: 110.4167, emoji: '🌾' },
            // JAWA TIMUR
            { name: 'Ngawi', province: 'Jawa Timur', latitude: -7.4003, longitude: 111.4557, emoji: '🌾' },
            { name: 'Lamongan', province: 'Jawa Timur', latitude: -7.1257, longitude: 112.4244, emoji: '🌾' },
            { name: 'Gresik', province: 'Jawa Timur', latitude: -7.1976, longitude: 112.6667, emoji: '🌾' },
            { name: 'Tuban', province: 'Jawa Timur', latitude: -6.9050, longitude: 112.0583, emoji: '🌾' },
            { name: 'Bojonegoro', province: 'Jawa Timur', latitude: -7.1750, longitude: 111.8833, emoji: '🌾' },
            { name: 'Surabaya', province: 'Jawa Timur', latitude: -7.2575, longitude: 112.7521, emoji: '🌾' },
            // SUMATERA UTARA
            { name: 'Medan', province: 'Sumatera Utara', latitude: 3.1957, longitude: 98.6722, emoji: '🌾' },
            { name: 'Deli Serdang', province: 'Sumatera Utara', latitude: 2.7667, longitude: 99.5167, emoji: '🌾' },
            // SUMATERA BARAT
            { name: 'Padang', province: 'Sumatera Barat', latitude: -0.9492, longitude: 100.3543, emoji: '🌾' },
            { name: 'Bukittinggi', province: 'Sumatera Barat', latitude: -0.3031, longitude: 100.3657, emoji: '🌾' },
            // RIAU
            { name: 'Pekanbaru', province: 'Riau', latitude: 0.5071, longitude: 101.4472, emoji: '🌾' },
            // SUMATERA SELATAN
            { name: 'Palembang', province: 'Sumatera Selatan', latitude: -2.9667, longitude: 104.7458, emoji: '🌾' },
            // LAMPUNG
            { name: 'Bandar Lampung', province: 'Lampung', latitude: -5.3971, longitude: 105.2667, emoji: '🌾' },
            // DKI JAKARTA
            { name: 'Jakarta', province: 'DKI Jakarta', latitude: -6.2088, longitude: 106.8456, emoji: '🌾' },
            // BANTEN
            { name: 'Serang', province: 'Banten', latitude: -6.1056, longitude: 106.1504, emoji: '🌾' },
            { name: 'Tangerang', province: 'Banten', latitude: -6.1728, longitude: 106.6325, emoji: '🌾' },
            // YOGYAKARTA
            { name: 'Yogyakarta', province: 'DI Yogyakarta', latitude: -7.7956, longitude: 110.3695, emoji: '🌾' },
            // KALIMANTAN BARAT
            { name: 'Pontianak', province: 'Kalimantan Barat', latitude: -0.0263, longitude: 109.3425, emoji: '🌾' },
            // KALIMANTAN TENGAH
            { name: 'Palangkaraya', province: 'Kalimantan Tengah', latitude: -1.7436, longitude: 113.9751, emoji: '🌾' },
            // KALIMANTAN SELATAN
            { name: 'Banjarmasin', province: 'Kalimantan Selatan', latitude: -3.3256, longitude: 114.5908, emoji: '🌾' },
            // KALIMANTAN TIMUR
            { name: 'Samarinda', province: 'Kalimantan Timur', latitude: -0.4947, longitude: 117.1431, emoji: '🌾' },
            // SULAWESI UTARA
            { name: 'Manado', province: 'Sulawesi Utara', latitude: 1.4748, longitude: 124.8628, emoji: '🌾' },
            // SULAWESI TENGAH
            { name: 'Palu', province: 'Sulawesi Tengah', latitude: -0.8915, longitude: 119.8701, emoji: '🌾' },
            // SULAWESI SELATAN
            { name: 'Makassar', province: 'Sulawesi Selatan', latitude: -5.1456, longitude: 119.4327, emoji: '🌾' },
            { name: 'Soppeng', province: 'Sulawesi Selatan', latitude: -4.5064, longitude: 119.7722, emoji: '🌾' },
            // SULAWESI TENGGARA
            { name: 'Kendari', province: 'Sulawesi Tenggara', latitude: -3.9704, longitude: 122.5090, emoji: '🌾' },
            // NUSA TENGGARA BARAT
            { name: 'Mataram', province: 'Nusa Tenggara Barat', latitude: -8.5847, longitude: 116.1269, emoji: '🌾' },
            // NUSA TENGGARA TIMUR
            { name: 'Kupang', province: 'Nusa Tenggara Timur', latitude: -10.1889, longitude: 123.5845, emoji: '🌾' },
            // BALI
            { name: 'Denpasar', province: 'Bali', latitude: -8.6705, longitude: 115.2126, emoji: '🌾' },
            // PAPUA BARAT
            { name: 'Manokwari', province: 'Papua Barat', latitude: -0.8667, longitude: 131.0833, emoji: '🌾' },
            // PAPUA
            { name: 'Jayapura', province: 'Papua', latitude: -2.5898, longitude: 140.6692, emoji: '🌾' },
        ];

        // Load locations on page load
        window.locationsData = fallbackLocations; // Set fallback as default
        
        // Load locations on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Populating locations from inline data...');
            populateLocationDropdown(fallbackLocations);
            console.log('Locations populated successfully');
        });

        function populateLocationDropdown(locations) {
            const select = document.getElementById('locationSelect');
            
            // Clear existing optgroups (keep the default option)
            while (select.options.length > 1) {
                select.remove(1);
            }
            
            // Group locations by province
            const grouped = {};
            locations.forEach(loc => {
                if (!grouped[loc.province]) {
                    grouped[loc.province] = [];
                }
                grouped[loc.province].push(loc);
            });

            // Create optgroup for each province
            Object.keys(grouped).sort().forEach(province => {
                const optgroup = document.createElement('optgroup');
                optgroup.label = province;
                
                grouped[province].forEach(loc => {
                    const option = document.createElement('option');
                    option.value = loc.name;
                    option.textContent = `${loc.emoji} ${loc.name}`;
                    optgroup.appendChild(option);
                });
                
                select.appendChild(optgroup);
            });
            
            console.log('Dropdown populated with', Object.keys(grouped).length, 'provinces');
        }

        // Rice Variety Recommendations Function
        async function getRiceRecommendations() {
            const soilType = document.getElementById('soilType').value;
            const rainfallCategory = document.getElementById('rainfallCategory').value;
            const temperatureOptimal = document.getElementById('temperatureOptimal').value;
            const elevationCategory = document.getElementById('elevationCategory').value;
            const waterAvailability = document.getElementById('waterAvailability').value;
            const salinityCategory = document.getElementById('salinityCategory').value;
            const threats = document.getElementById('threats').value;

            if (!soilType || !rainfallCategory || !temperatureOptimal || !elevationCategory || !waterAvailability || !salinityCategory) {
                alert('Mohon lengkapi semua parameter');
                return;
            }

            const resultsDiv = document.getElementById('riceResults');
            resultsDiv.innerHTML = '<div class="bg-gray-100 rounded-lg p-8 text-center"><p>Loading...</p></div>';

            try {
                const response = await fetch('/api/rice-recommendations', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        soil_type: soilType,
                        rainfall_category: rainfallCategory,
                        temperature_optimal: temperatureOptimal,
                        elevation_category: elevationCategory,
                        water_availability: waterAvailability,
                        salinity_category: salinityCategory,
                        threats: threats || null
                    })
                });

                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                
                if (data.recommendations && data.recommendations.length > 0) {
                    let html = '<div class="space-y-4">';
                    data.recommendations.forEach((variety, index) => {
                        // Color coding based on match score
                        let scoreColor = variety.match_score >= 80 ? 'bg-green-100 text-green-800 border-green-300' :
                                       variety.match_score >= 60 ? 'bg-blue-100 text-blue-800 border-blue-300' :
                                       'bg-yellow-100 text-yellow-800 border-yellow-300';
                        
                        let scoreLabel = variety.match_score >= 80 ? 'Sangat Cocok' :
                                        variety.match_score >= 60 ? 'Cocok' :
                                        'Kurang Cocok';

                        html += `
                            <div class="bg-white rounded-lg border-l-4 border-green-600 p-6 shadow-md hover:shadow-lg transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <h4 class="text-xl font-bold text-gray-900">${index + 1}. ${variety.name}</h4>
                                        <p class="text-gray-600 text-sm mt-1">${variety.description}</p>
                                    </div>
                                    <span class="ml-4 px-4 py-2 rounded-lg font-bold text-sm whitespace-nowrap ${scoreColor} border">${scoreLabel} (${variety.match_score}%)</span>
                                </div>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 pt-4 border-t border-gray-200">
                                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-3">
                                        <p class="text-xs text-gray-600 font-semibold">📊 Hasil Panen</p>
                                        <p class="text-lg font-bold text-orange-600">${variety.yield_potential} ton/ha</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-3">
                                        <p class="text-xs text-gray-600 font-semibold">⏰ Umur Panen</p>
                                        <p class="text-lg font-bold text-blue-600">${variety.maturity_days} hari</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-3">
                                        <p class="text-xs text-gray-600 font-semibold">🌍 Jenis Tanah</p>
                                        <p class="text-sm font-bold text-green-600 capitalize">${variety.soil_type.replace(/_/g, ' ')}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-3">
                                        <p class="text-xs text-gray-600 font-semibold">💧 Ketersediaan Air</p>
                                        <p class="text-sm font-bold text-purple-600 capitalize">${variety.water_availability.replace(/_/g, ' ')}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm bg-gray-100 px-2 py-1 rounded">🌡️ ${variety.temperature_optimal}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm bg-gray-100 px-2 py-1 rounded">📍 ${variety.elevation_category.replace(/_/g, ' ')}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm bg-gray-100 px-2 py-1 rounded">🧂 ${variety.salinity_category}</span>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    resultsDiv.innerHTML = html;
                } else {
                    resultsDiv.innerHTML = '<div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-6 text-center"><p class="text-yellow-800 font-semibold">ℹ️ Tidak ada rekomendasi yang cocok dengan parameter yang Anda pilih. Coba sesuaikan parameter lain.</p></div>';
                }
            } catch (error) {
                console.error('Error:', error);
                resultsDiv.innerHTML = '<div class="bg-red-100 rounded-lg p-8 text-center text-red-600"><p>Terjadi kesalahan. Silakan coba lagi.</p></div>';
            }
        }

        // Add event listeners for article search and filter
        document.addEventListener('DOMContentLoaded', function() {
            // Load articles on page load
            loadArticles();

            // Search input listener
            const searchInput = document.getElementById('articleSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    loadArticles();
                });
            }

            // Category filter listener
            const categoryFilter = document.getElementById('categoryFilter');
            if (categoryFilter) {
                categoryFilter.addEventListener('change', function() {
                    loadArticles();
                });
            }
        });
    </script>
</body>
</html>
