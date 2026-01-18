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
            background-image: url('https://images.unsplash.com/photo-1574943320219-553eb213f72d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=90&sat=20');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-color: #f9fafb;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
            min-height: 100vh;
            position: relative;
            filter: saturate(1.3) brightness(1.05);
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.50) 0%, rgba(240, 253, 250, 0.50) 50%, rgba(255, 255, 255, 0.50) 100%);
            z-index: -1;
            pointer-events: none;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .brand-text h1 {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            line-height: 1;
        }

        .brand-text p {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }

        .welcome-section {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            border-radius: 12px;
            padding: 40px;
            margin-bottom: 32px;
            color: white;
            box-shadow: 0 12px 32px rgba(16, 185, 129, 0.35);
        }

        .welcome-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .welcome-section p {
            font-size: 1.1rem;
            opacity: 0.98;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .tabs-container {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .tabs-header {
            display: flex;
            justify-content: center;
            gap: 24px;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 24px;
            overflow-x: auto;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }

        .tab-button {
            padding: 12px 20px;
            background: white;
            border: 2px solid #e5e7eb;
            color: #6b7280;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            border-radius: 8px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .tab-button:hover {
            color: #059669;
            border-color: #10b981;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            transform: translateY(-2px);
        }

        .tab-button.active {
            color: white;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-color: #059669;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.4);
        }

        .tabs-content {
            padding: 24px;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
            animation: fadeIn 0.3s ease;
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
            color: #1f2937;
        }

        .form-control:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .form-control::placeholder {
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
            font-size: 14px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            padding: 10px 20px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .card {
            background: rgba(255, 255, 255, 0.96);
            border: 2px solid #10b981;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.12);
        }

        .card:hover {
            border-color: #059669;
            box-shadow: 0 12px 28px rgba(16, 185, 129, 0.2);
        }

        .article-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
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
            transition: transform 0.3s ease;
        }

        .article-card:hover .article-image {
            transform: scale(1.05);
        }

        .article-body {
            padding: 16px;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 12px;
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

        .badge-hama {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-teknologi {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .grid-cols-auto {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .empty-state-text {
            color: #6b7280;
            margin-bottom: 20px;
        }

        .logout-btn {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fca5a5;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #fecaca;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="navbar-brand">
                <div class="brand-icon">🌾</div>
                <div class="brand-text">
                    <h1>TaniOptimal</h1>
                    <p>Smart Farming Platform</p>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">Petani</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Welcome Banner -->
        <div class="welcome-section">
            <h2>Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
            <p>Kelola pertanian padi Anda dengan solusi teknologi terkini dan rekomendasi berbasis AI</p>
        </div>

        <!-- Tabs -->
        <div class="tabs-container">
            <!-- Tab Headers -->
            <div class="tabs-header">
                <button class="tab-button active" onclick="switchTab('articles')" title="Baca artikel pertanian terbaru">
                    <span>📚 Artikel</span>
                </button>
                <button class="tab-button" onclick="switchTab('rice')" title="Rekomendasi varietas padi">
                    <span>🌾 Varietas Padi</span>
                </button>
                <button class="tab-button" onclick="switchTab('schedule')" title="Kelola jadwal tanam">
                    <span>📅 Jadwal Tanam</span>
                </button>
            </div>

            <!-- Tab Contents -->
            <div class="tabs-content">
                <!-- Articles Tab -->
                <div id="articles" class="tab-pane active">
                    <div class="mb-6 flex flex-col sm:flex-row gap-4">
                        <div class="flex-1 relative">
                            <i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i>
                            <input 
                                type="text" 
                                placeholder="Cari artikel..." 
                                id="articleSearch"
                                class="form-control pl-10 w-full"
                                onkeyup="loadArticles()"
                            >
                        </div>
                        <select id="categoryFilter" class="form-control sm:w-48" onchange="loadArticles()">
                            <option value="">Semua Kategori</option>
                            <option value="1">🐛 Hama</option>
                            <option value="2">🔬 Teknologi Pertanian</option>
                            <option value="3">📰 Informasi Perkembangan Pertanian</option>
                        </select>
                    </div>

                    <div class="grid-cols-auto" id="articlesContainer">
                        <div class="col-span-3 empty-state">
                            <div class="empty-state-icon">📚</div>
                            <div class="empty-state-text">Memuat artikel...</div>
                        </div>
                    </div>
                </div>

                <!-- Rice Variety Tab -->
                <div id="rice" class="tab-pane">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="card">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">🌾 Rekomendasi Varietas Padi</h3>
                            
                            <div class="space-y-6">
                                <!-- 1. Jenis Tanah (bobot 4) -->
                                <div class="form-group">
                                    <label>1️⃣ Jenis Tanah <span class="text-xs text-gray-500">(bobot 4)</span></label>
                                    <select id="soilType" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="ultisol">Ultisol (skor 3)</option>
                                        <option value="liat">Liat (skor 2)</option>
                                        <option value="aluvial">Aluvial (skor 1)</option>
                                    </select>
                                </div>

                                <!-- 2. Curah Hujan (bobot 2) -->
                                <div class="form-group">
                                    <label>2️⃣ Curah Hujan (mm/tahun) <span class="text-xs text-gray-500">(bobot 2)</span></label>
                                    <select id="rainfall" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="1500_1800">1500–1800 mm (skor 3)</option>
                                        <option value="1200_1500">1200–1500 mm (skor 2)</option>
                                        <option value="800_1200">800–1200 mm (skor 1)</option>
                                    </select>
                                </div>

                                <!-- 3. Suhu Optimal (bobot 3) -->
                                <div class="form-group">
                                    <label>3️⃣ Suhu Optimal (°C) <span class="text-xs text-gray-500">(bobot 3)</span></label>
                                    <select id="temperature" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="30_35">30–35°C (skor 3)</option>
                                        <option value="27_29">27–29°C (skor 2)</option>
                                        <option value="25_26">25–26°C (skor 1)</option>
                                    </select>
                                </div>

                                <!-- 4. Ketinggian Lahan (bobot 1) -->
                                <div class="form-group">
                                    <label>4️⃣ Ketinggian Lahan (mdpl) <span class="text-xs text-gray-500">(bobot 1)</span></label>
                                    <select id="altitude" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="800_1200">1200–800 mdpl (skor 3)</option>
                                        <option value="500_800">800–500 mdpl (skor 2)</option>
                                        <option value="0_500">500–0 mdpl (skor 1)</option>
                                    </select>
                                </div>

                                <!-- 5. Ketersediaan Air (bobot 5) -->
                                <div class="form-group">
                                    <label>5️⃣ Ketersediaan Air <span class="text-xs text-gray-500">(bobot 5)</span></label>
                                    <select id="waterAvailability" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="rawa">Rawa (skor 3)</option>
                                        <option value="irigasi_sederhana">Irigasi Sederhana (skor 2)</option>
                                        <option value="tadah_hujan">Tadah Hujan (skor 1)</option>
                                    </select>
                                </div>

                                <button onclick="getRiceRecommendations()" class="btn-primary w-full">
                                    🔍 Cari Rekomendasi
                                </button>
                            </div>
                        </div>

                        <div id="riceResults">
                            <div class="empty-state">
                                <div class="empty-state-icon">🌾</div>
                                <div class="empty-state-text">Pilih parameter dan klik "Cari Rekomendasi"</div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Schedule Tab -->
                <div id="schedule" class="tab-pane">
                    <div class="card border-l-4 border-green-600 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">➕ Buat Jadwal Tanam Baru</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <select class="form-control" id="scheduleRiceVariety">
                                <option value="">-- Memuat varietas padi... --</option>
                            </select>
                            <input type="date" id="schedulePlantDate" class="form-control">
                            <button class="btn-primary" onclick="createSchedule()">➕ Buat</button>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">📋 Jadwal Aktif</h3>
                        <div id="activeSchedulesContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-pane').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName).classList.add('active');
            event.target.closest('.tab-button').classList.add('active');

            // Load data if needed
            if (tabName === 'articles') {
                loadArticles();
            } else if (tabName === 'rice') {
                loadDroughtResistantRanking();
            }
        }

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
                    container.innerHTML = `
                        <div class="col-span-3 empty-state">
                            <div class="empty-state-icon">📚</div>
                            <div class="empty-state-text">Belum ada artikel tersedia</div>
                        </div>
                    `;
                    return;
                }
                
                const categoryColors = {
                    '1': { badge: 'badge-hama', icon: '🐛', name: 'Hama' },
                    '2': { badge: 'badge-teknologi', icon: '🔬', name: 'Teknologi Pertanian' },
                    '3': { badge: 'badge-info', icon: '📰', name: 'Informasi Perkembangan Pertanian' }
                };
                
                container.innerHTML = data.data.map(article => {
                    const categoryId = article.category_id ? article.category_id.toString() : '1';
                    const colors = categoryColors[categoryId] || categoryColors['1'];
                    const imageUrl = article.featured_image 
                        ? `/storage/${article.featured_image.includes('articles/') ? article.featured_image : 'articles/' + article.featured_image}` 
                        : 'https://via.placeholder.com/400x200?text=TaniOptimal';
                    
                    const shortContent = article.content.replace(/<[^>]*>/g, '').substring(0, 100);
                    
                    // Jika artikel punya link, redirect ke link tersebut, jika tidak ke halaman artikel
                    const readMoreUrl = article.link ? article.link : `/articles/${article.id}`;
                    const isExternalLink = article.link ? '_blank' : '_self';
                    
                    return `
                        <div class="article-card">
                            <img src="${imageUrl}" alt="${article.title}" class="article-image">
                            <div class="article-body">
                                <span class="badge ${colors.badge}">${colors.icon} ${colors.name}</span>
                                <h4 class="font-bold text-gray-900 mb-2">${article.title}</h4>
                                <p class="text-sm text-gray-600 mb-4">${shortContent}...</p>
                                <a href="${readMoreUrl}" target="${isExternalLink}" class="text-green-600 font-semibold text-sm hover:text-green-700">
                                    Baca selengkapnya →
                                </a>
                            </div>
                        </div>
                    `;
                }).join('');
            } catch (error) {
                console.error('Error loading articles:', error);
                document.getElementById('articlesContainer').innerHTML = `
                    <div class="col-span-3 empty-state">
                        <div class="empty-state-icon">⚠️</div>
                        <div class="empty-state-text">Gagal memuat artikel</div>
                    </div>
                `;
            }
        }

        // Load Rice Varieties from API
        let allRiceVarieties = [];
        
        async function loadRiceVarietiesFromApi() {
            try {
                const response = await fetch('/api/rice-varieties');
                const result = await response.json();
                
                if (result.data && result.data.length > 0) {
                    allRiceVarieties = result.data;
                    const select = document.getElementById('scheduleRiceVariety');
                    select.innerHTML = '<option value="">-- Pilih Varietas Padi --</option>';
                    
                    result.data.forEach(variety => {
                        const option = document.createElement('option');
                        option.value = variety.id;
                        option.textContent = `🌾 ${variety.name}`;
                        option.dataset.maturityDays = variety.maturity_days;
                        option.dataset.varietyId = variety.id;
                        select.appendChild(option);
                    });
                    console.log(`Berhasil memuat ${result.data.length} varietas padi`);
                }
            } catch (error) {
                console.error('Error loading rice varieties:', error);
                const select = document.getElementById('scheduleRiceVariety');
                select.innerHTML = '<option value="">-- Gagal memuat varietas padi --</option>';
            }
        }

        // Load varieties when page loads
        window.addEventListener('load', function() {
            loadRiceVarietiesFromApi();
        });

        // Data Varietas Padi dengan Kriteria
        const riceVarieties = [
            {
                name: 'Padi Inpari 42',
                description: 'Varietas hibrida dengan potensi hasil tinggi',
                icon: '🌾',
                maturityAge: 110,
                soilScore: { 'ultisol_inseptisol': 4, 'liat_berpasir': 3, 'aluvial': 2, 'gleysol_andosol': 1 },
                rainfallScore: { '800_1200': 4, '1200_1500': 3, '1500_1800': 2, 'above_1800': 1 },
                temperatureScore: { '30_35': 4, '27_29': 3, '25_26': 2, 'below_25': 1 },
                altitudeScore: { '0_500': 4, '500_800': 3, '800_1200': 2, 'above_1200': 1 },
                waterScore: { 'rainwater': 4, 'simple_irrigation': 3, 'medium_water': 2, 'excess_water': 1 }
            },
            {
                name: 'Padi Ciherang',
                description: 'Varietas adaptif dengan toleransi cukup baik',
                icon: '🌿',
                maturityAge: 115,
                soilScore: { 'ultisol_inseptisol': 3, 'liat_berpasir': 4, 'aluvial': 3, 'gleysol_andosol': 2 },
                rainfallScore: { '800_1200': 3, '1200_1500': 4, '1500_1800': 3, 'above_1800': 2 },
                temperatureScore: { '30_35': 3, '27_29': 4, '25_26': 3, 'below_25': 2 },
                altitudeScore: { '0_500': 3, '500_800': 4, '800_1200': 3, 'above_1200': 1 },
                waterScore: { 'rainwater': 3, 'simple_irrigation': 4, 'medium_water': 3, 'excess_water': 2 }
            },
            {
                name: 'Padi IR64',
                description: 'Varietas unggul dengan daya tahan terhadap penyakit',
                icon: '🌾',
                maturityAge: 120,
                soilScore: { 'ultisol_inseptisol': 3, 'liat_berpasir': 3, 'aluvial': 4, 'gleysol_andosol': 3 },
                rainfallScore: { '800_1200': 3, '1200_1500': 3, '1500_1800': 4, 'above_1800': 3 },
                temperatureScore: { '30_35': 3, '27_29': 3, '25_26': 4, 'below_25': 2 },
                altitudeScore: { '0_500': 4, '500_800': 3, '800_1200': 3, 'above_1200': 2 },
                waterScore: { 'rainwater': 3, 'simple_irrigation': 3, 'medium_water': 4, 'excess_water': 3 }
            },
            {
                name: 'Padi Maro',
                description: 'Varietas tahan rendaman dan banjir',
                icon: '💧',
                maturityAge: 125,
                soilScore: { 'ultisol_inseptisol': 2, 'liat_berpasir': 2, 'aluvial': 3, 'gleysol_andosol': 4 },
                rainfallScore: { '800_1200': 2, '1200_1500': 2, '1500_1800': 3, 'above_1800': 4 },
                temperatureScore: { '30_35': 2, '27_29': 2, '25_26': 3, 'below_25': 4 },
                altitudeScore: { '0_500': 3, '500_800': 3, '800_1200': 3, 'above_1200': 4 },
                waterScore: { 'rainwater': 2, 'simple_irrigation': 2, 'medium_water': 4, 'excess_water': 4 }
            },
            {
                name: 'Padi Grogol',
                description: 'Varietas lokal dengan adaptasi lahan kering',
                icon: '🏜️',
                maturityAge: 115,
                soilScore: { 'ultisol_inseptisol': 4, 'liat_berpasir': 4, 'aluvial': 2, 'gleysol_andosol': 1 },
                rainfallScore: { '800_1200': 4, '1200_1500': 2, '1500_1800': 1, 'above_1800': 1 },
                temperatureScore: { '30_35': 4, '27_29': 2, '25_26': 1, 'below_25': 1 },
                altitudeScore: { '0_500': 4, '500_800': 3, '800_1200': 2, 'above_1200': 1 },
                waterScore: { 'rainwater': 4, 'simple_irrigation': 3, 'medium_water': 1, 'excess_water': 1 }
            }
        ];

        function getRiceRecommendations() {
            // Get selected values
            const soil = document.getElementById('soilType').value;
            const rainfall = document.getElementById('rainfall').value;
            const temperature = document.getElementById('temperature').value;
            const altitude = document.getElementById('altitude').value;
            const water = document.getElementById('waterAvailability').value;

            // Validation
            if (!soil || !rainfall || !temperature || !altitude || !water) {
                alert('Mohon lengkapi semua parameter!');
                return;
            }

            // Get display labels untuk selected values
            const soilLabel = document.getElementById('soilType').options[document.getElementById('soilType').selectedIndex].text;
            const rainfallLabel = document.getElementById('rainfall').options[document.getElementById('rainfall').selectedIndex].text;
            const temperatureLabel = document.getElementById('temperature').options[document.getElementById('temperature').selectedIndex].text;
            const altitudeLabel = document.getElementById('altitude').options[document.getElementById('altitude').selectedIndex].text;
            const waterLabel = document.getElementById('waterAvailability').options[document.getElementById('waterAvailability').selectedIndex].text;

            // Kriteria weights
            const weights = {
                'c1': 4,  // Jenis Tanah
                'c2': 2,  // Curah Hujan
                'c3': 3,  // Suhu Optimal
                'c4': 1,  // Ketinggian Lahan
                'c5': 5   // Ketersediaan Air
            };

            const totalWeight = 4 + 2 + 3 + 1 + 5; // Total = 15

            // Score mapping berdasarkan pilihan user
            const scoreMap = {
                soil: {
                    'ultisol': { 'c1': 3 },
                    'liat': { 'c1': 2 },
                    'aluvial': { 'c1': 1 }
                },
                rainfall: {
                    '800_1200': { 'c2': 3 },
                    '1200_1500': { 'c2': 2 },
                    '1500_1800': { 'c2': 1 }
                },
                temperature: {
                    '30_35': { 'c3': 3 },
                    '27_29': { 'c3': 2 },
                    '25_26': { 'c3': 1 }
                },
                altitude: {
                    '800_1200': { 'c4': 3 },
                    '500_800': { 'c4': 2 },
                    '0_500': { 'c4': 1 }
                },
                water: {
                    'rawa': { 'c5': 3 },
                    'irigasi_sederhana': { 'c5': 2 },
                    'tadah_hujan': { 'c5': 1 }
                }
            };

            // Get user scores
            const userScores = {
                ...scoreMap.soil[soil],
                ...scoreMap.rainfall[rainfall],
                ...scoreMap.temperature[temperature],
                ...scoreMap.altitude[altitude],
                ...scoreMap.water[water]
            };

            // Fetch varieties dari API dan hitung SAW scores
            fetch('/api/rice-saw/varieties')
                .then(response => response.json())
                .then(result => {
                    if (!result.data || result.data.length === 0) {
                        alert('Data varietas padi tidak tersedia');
                        return;
                    }

                    const varieties = result.data;
                    
                    // Hitung SAW scores untuk setiap varietas
                    const scoredVarieties = varieties.map(variety => {
                        let totalScore = 0;

                        // Hitung weighted score dengan perbandingan: semakin mirip dengan user score, semakin tinggi nilai
                        for (let criteriaCode in userScores) {
                            const varietyScore = variety.scores[criteriaCode]?.score || 0;
                            const weight = weights[criteriaCode];
                            const userScore = userScores[criteriaCode];

                            // Hitung similarity (persamaan): jika variety score sama dengan user score, nilai 1
                            // Jika berbeda jauh, nilai lebih kecil
                            // Rumus: 1 - (|varietyScore - userScore| / 3)
                            // Score range 1-3, jadi max difference = 2
                            const similarity = Math.max(0, 1 - (Math.abs(varietyScore - userScore) / 2));
                            totalScore += similarity * weight;
                        }

                        const finalScore = (totalScore / totalWeight) * 100;

                        // Define ranking data based on SAW scores
                        const rankingData = {
                            'Nagina 22': { rank: 1, icon: '🥇', sawScore: 16.0, performance: 'Sangat Tahan' },
                            'Inpago 8': { rank: 2, icon: '🥈', sawScore: 14.0, performance: 'Sangat Tahan' },
                            'DRR Dhan 42': { rank: 3, icon: '🥉', sawScore: 8.8, performance: 'Tahan' },
                            'Sahbhagi Dhan': { rank: 4, icon: '4️⃣', sawScore: 7.7, performance: 'Cukup Tahan' },
                            'Vandana': { rank: 5, icon: '5️⃣', sawScore: 6.3, performance: 'Kurang Tahan' }
                        };

                        const ranking = rankingData[variety.name] || { rank: 0, icon: '❓', sawScore: 0, performance: 'Tidak Diketahui' };

                        return {
                            id: variety.id,
                            name: variety.name,
                            description: variety.description,
                            yield_potential: variety.yield_potential,
                            maturity_days: variety.maturity_days,
                            finalScore: Math.round(finalScore),
                            rankingIcon: ranking.icon,
                            rankingPosition: ranking.rank,
                            sawScore: ranking.sawScore,
                            performance: ranking.performance
                        };
                    });

                    // Sort by score descending
                    scoredVarieties.sort((a, b) => b.finalScore - a.finalScore);

                    // Display top 1 result
                    const resultsDiv = document.getElementById('riceResults');
                    const topVariety = scoredVarieties[0];

                    if (!topVariety) {
                        resultsDiv.innerHTML = '<div class="empty-state"><div class="empty-state-text">Tidak ada hasil rekomendasi</div></div>';
                        return;
                    }

                    resultsDiv.innerHTML = `
                        <div class="space-y-4">
                            <div class="card border-l-4 border-blue-600 bg-blue-50">
                                <p class="text-sm text-blue-800 mb-2"><strong>ℹ️ Informasi:</strong></p>
                                <p class="text-xs text-blue-700 leading-relaxed">Berdasarkan parameter yang Anda pilih (SAW Method), sistem merekomendasikan varietas padi berikut yang memiliki tingkat kecocokan paling tinggi (${topVariety.finalScore}%). Varietas ini paling sesuai dengan kondisi lahan, iklim, dan ketersediaan air di area Anda.</p>
                            </div>
                            <div class="card border-l-4 border-green-600 bg-green-50">
                                <p class="text-sm font-semibold text-green-800">🌾 Rekomendasi Teratas</p>
                            </div>
                            <div class="card border-l-4 border-green-600 bg-gradient-to-r from-green-50 to-transparent">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-bold text-lg text-gray-900">🌾 ${topVariety.name}</h4>
                                        <p class="text-sm text-gray-600 mt-1">${topVariety.description || 'Varietas unggul dengan adaptasi baik'}</p>
                                        <p class="text-xs text-gray-500 mt-2">🌱 Hasil: ${topVariety.yield_potential} ton/ha | ⏱ Maturity: ${topVariety.maturity_days} hari</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-3xl font-bold text-green-600">${topVariety.finalScore}%</div>
                                        <p class="text-xs text-gray-500 mt-1">Kesesuaian</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-5 gap-2 text-center text-xs">
                                    <div class="p-2 bg-gray-100 rounded">
                                        <p class="text-gray-700 font-semibold text-xs">${soilLabel}</p>
                                        <p class="text-gray-500 text-xs mt-1">Tanah</p>
                                    </div>
                                    <div class="p-2 bg-gray-100 rounded">
                                        <p class="text-gray-700 font-semibold text-xs">${rainfallLabel}</p>
                                        <p class="text-gray-500 text-xs mt-1">Hujan</p>
                                    </div>
                                    <div class="p-2 bg-gray-100 rounded">
                                        <p class="text-gray-700 font-semibold text-xs">${temperatureLabel}</p>
                                        <p class="text-gray-500 text-xs mt-1">Suhu</p>
                                    </div>
                                    <div class="p-2 bg-gray-100 rounded">
                                        <p class="text-gray-700 font-semibold text-xs">${altitudeLabel}</p>
                                        <p class="text-gray-500 text-xs mt-1">Tinggi</p>
                                    </div>
                                    <div class="p-2 bg-gray-100 rounded">
                                        <p class="text-gray-700 font-semibold text-xs">${waterLabel}</p>
                                        <p class="text-gray-500 text-xs mt-1">Air</p>
                                    </div>
                                </div>
                                
                                <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: ${topVariety.finalScore}%"></div>
                                </div>
                            </div>

                            <!-- Ranking Section - Hanya menampilkan varietas yang direkomendasikan -->
                            <div class="card border-l-4 border-orange-600 bg-orange-50 mt-6">
                                <h4 class="text-lg font-bold text-gray-900 mb-4">🏆 Analisis Ranking Tahan Kekeringan</h4>
                                <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-start gap-3">
                                            <span class="text-4xl">${topVariety.rankingIcon}</span>
                                            <div>
                                                <h5 class="font-bold text-gray-900">${topVariety.name}</h5>
                                                <p class="text-xs text-gray-500 mt-1">${topVariety.description || 'Varietas unggul dengan adaptasi baik'}</p>
                                            </div>
                                        </div>
                                        <span class="badge bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">${topVariety.performance}</span>
                                    </div>
                                    
                                    <div class="grid grid-cols-3 gap-4 mt-3">
                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold">SAW Score</p>
                                            <p class="text-lg font-bold text-gray-900">${topVariety.sawScore.toFixed(1)}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold">Ranking</p>
                                            <p class="text-lg font-bold text-gray-900">#${topVariety.rankingPosition} dari 5</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold">Kecocokan Parameter</p>
                                            <p class="text-lg font-bold text-green-600">${topVariety.finalScore}%</p>
                                        </div>
                                    </div>
                                    
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                        <div class="bg-green-600 h-2 rounded-full transition-all" style="width: ${(topVariety.rankingPosition / 5) * 100}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error fetching varieties:', error);
                    alert('Gagal memuat data varietas padi');
                });
        }

        // Store schedules in array
        let schedules = [];

        function createSchedule() {
            const varietySelect = document.getElementById('scheduleRiceVariety');
            const plantDateInput = document.getElementById('schedulePlantDate');
            
            const riceVarietyValue = varietySelect.value;
            const plantDate = plantDateInput.value;

            // Validation
            if (!riceVarietyValue) {
                alert('Pilih varietas padi terlebih dahulu!');
                return;
            }

            if (!plantDate) {
                alert('Masukkan tanggal tanam!');
                return;
            }

            // Get rice variety name and maturity days from dataset
            const riceVarietyOption = varietySelect.options[varietySelect.selectedIndex];
            const riceVarietyName = riceVarietyOption.text;
            const maturityDays = parseInt(riceVarietyOption.dataset.maturityDays) || 120;

            // Calculate harvest date based on maturity days
            const plantDateObj = new Date(plantDate);
            const harvestDateObj = new Date(plantDateObj);
            harvestDateObj.setDate(harvestDateObj.getDate() + maturityDays);

            // Format dates
            const formatter = new Intl.DateTimeFormat('id-ID', { 
                day: 'numeric', 
                month: 'short',
                year: 'numeric'
            });
            
            const plantDateFormatted = new Intl.DateTimeFormat('id-ID', { 
                day: 'numeric', 
                month: 'short'
            }).format(plantDateObj);
            
            const harvestDateFormatted = new Intl.DateTimeFormat('id-ID', { 
                day: 'numeric', 
                month: 'short'
            }).format(harvestDateObj);

            // Calculate age difference in days
            const ageDays = Math.floor((harvestDateObj - plantDateObj) / (1000 * 60 * 60 * 24));

            // Create schedule object
            const schedule = {
                id: Date.now(),
                riceVariety: riceVarietyName,
                plantDate: plantDate,
                plantDateFormatted: plantDateFormatted,
                harvestDate: harvestDateFormatted,
                ageDays: ageDays,
                status: 'Planned'
            };

            // Add to schedules array
            schedules.push(schedule);

            // Clear form
            varietySelect.value = '';
            plantDateInput.value = '';

            // Render schedules
            renderSchedules();

            // Show success message
            alert('Jadwal tanam berhasil dibuat!');
        }

        function renderSchedules() {
            const container = document.getElementById('activeSchedulesContainer');

            if (schedules.length === 0) {
                container.innerHTML = `
                    <div class="card border-l-4 border-gray-300">
                        <div class="text-center py-8">
                            <p class="text-gray-500">Belum ada jadwal tanam. Buat jadwal baru untuk memulai.</p>
                        </div>
                    </div>
                `;
                return;
            }

            container.innerHTML = schedules.map(schedule => `
                <div class="card border-l-4 border-green-600 mb-4">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">${schedule.riceVariety}</h4>
                            <p class="text-gray-600"></p>
                        </div>
                        <span style="background: #dcfce7; color: #166534; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 12px;">🟢 ${schedule.status}</span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 bg-gray-50 rounded-lg p-6 mb-6">
                        <div>
                            <p class="text-xs text-gray-600 font-semibold">📌 TANAM</p>
                            <p class="text-2xl font-bold text-green-600">${schedule.plantDateFormatted}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold">🌾 PANEN</p>
                            <p class="text-2xl font-bold text-green-600">${schedule.harvestDate}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold">⏳ UMUR</p>
                            <p class="text-2xl font-bold text-green-600">${schedule.ageDays} hari</p>
                        </div>
                    </div>

                    <div>
                        <p class="font-bold text-gray-900 mb-4">✓ Pre-Planting Tasks:</p>
                        <ul class="space-y-3 text-gray-700 text-sm">
                            <li>✓ Siapkan benih unggul (21 hari sebelum tanam)</li>
                            <li>✓ Bajak lahan secara menyeluruh (14 hari)</li>
                            <li>✓ Siapkan sistem irigasi (7 hari)</li>
                            <li>• Beli pupuk dan pestisida (3 hari)</li>
                            <li>• Rekrutmen tenaga kerja (2 hari)</li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <button class="text-red-600 hover:text-red-800 font-semibold text-sm" onclick="deleteSchedule(${schedule.id})">
                            🗑️ Hapus Jadwal
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function deleteSchedule(scheduleId) {
            schedules = schedules.filter(s => s.id !== scheduleId);
            renderSchedules();
        }

        // Load Drought Resistant Ranking (SAW Method)
        async function loadDroughtResistantRanking() {
            try {
                const container = document.getElementById('droughtRankingContainer');
                container.innerHTML = '<div class="text-center text-gray-600 py-4">Memuat ranking...</div>';

                // Ranking predefined berdasarkan SAW calculation
                // Nagina 22 (1) → Inpago 8 (2) → DRR Dhan 42 (3) → Sahbhagi Dhan (4) → Vandana (5)
                const droughtResistantRanking = [
                    {
                        rank: 1,
                        name: 'Nagina 22',
                        description: 'Varietas premium dengan aroma khas',
                        sawScore: 16.0,
                        performance: 'Sangat Tahan',
                        icon: '🥇'
                    },
                    {
                        rank: 2,
                        name: 'Inpago 8',
                        description: 'Varietas unggul dengan hasil tinggi',
                        sawScore: 14.0,
                        performance: 'Sangat Tahan',
                        icon: '🥈'
                    },
                    {
                        rank: 3,
                        name: 'DRR Dhan 42',
                        description: 'Varietas tahan stres dengan adaptasi baik',
                        sawScore: 8.8,
                        performance: 'Tahan',
                        icon: '🥉'
                    },
                    {
                        rank: 4,
                        name: 'Sahbhagi Dhan',
                        description: 'Varietas unggul dengan hasil stabil',
                        sawScore: 7.7,
                        performance: 'Cukup Tahan',
                        icon: '4️⃣'
                    },
                    {
                        rank: 5,
                        name: 'Vandana',
                        description: 'Varietas tahan kekeringan dan lahan marjinal',
                        sawScore: 6.3,
                        performance: 'Kurang Tahan',
                        icon: '5️⃣'
                    }
                ];

                if (droughtResistantRanking.length === 0) {
                    container.innerHTML = '<div class="text-center text-gray-600 py-4">Data ranking tidak tersedia</div>';
                    return;
                }

                // Render ranking
                container.innerHTML = droughtResistantRanking.map((item, idx) => {
                    const progressBarColor = idx === 0 ? 'bg-yellow-500' : idx === 1 ? 'bg-gray-400' : idx === 2 ? 'bg-amber-700' : idx === 3 ? 'bg-green-500' : 'bg-blue-500';
                    const performanceColor = item.performance === 'Sangat Tahan' ? 'bg-green-100 text-green-800' : 
                                            item.performance === 'Tahan' ? 'bg-yellow-100 text-yellow-800' : 
                                            'bg-orange-100 text-orange-800';
                    
                    return `
                        <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-lg transition">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <span class="text-3xl">${item.icon}</span>
                                    <div>
                                        <p class="font-bold text-gray-900">${item.name}</p>
                                        <p class="text-xs text-gray-500">${item.description}</p>
                                    </div>
                                </div>
                                <span class="badge ${performanceColor} text-xs font-semibold px-3 py-1 rounded-full">${item.performance}</span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-3">
                                <div>
                                    <p class="text-xs text-gray-600 font-semibold">SAW Score</p>
                                    <p class="text-lg font-bold text-gray-900">${item.sawScore.toFixed(1)}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 font-semibold">Ranking</p>
                                    <p class="text-lg font-bold text-gray-900">#${item.rank} dari 5</p>
                                </div>
                            </div>
                            
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="${progressBarColor} h-2 rounded-full transition-all" style="width: ${(item.rank / 5) * 100}%"></div>
                            </div>
                        </div>
                    `;
                }).join('');
            } catch (error) {
                console.error('Error loading drought resistant ranking:', error);
                document.getElementById('droughtRankingContainer').innerHTML = `
                    <div class="text-center text-red-600 py-4">Gagal memuat ranking</div>
                `;
            }
        }

        // Load articles on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadArticles();
            renderSchedules();
        });
    </script>
</body>
</html>
