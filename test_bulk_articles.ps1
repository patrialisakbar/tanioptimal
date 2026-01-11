$articles = @(
    @{
        title = 'Teknologi Irigasi Tetes untuk Efisiensi Air'
        content = 'Irigasi tetes adalah teknologi modern yang menghemat hingga 60% penggunaan air. Sistem ini tepat sasaran dan efisien untuk pertanian di daerah dengan cuaca ekstrim. Pelajari cara instalasi dan perawatan di artikel lengkap kami.'
        category_id = 2
        link = 'https://www.example.com/teknologi-irigasi-tetes'
        is_published = $true
    },
    @{
        title = 'Update Harga Benih Padi Premium 2026'
        content = 'Harga benih padi premium mengalami kenaikan 15% di awal tahun 2026. Beberapa varietas langka menjadi paling dicari petani modern. Cek daftar harga terbaru dan supplier terpercaya di sini.'
        category_id = 3
        link = 'https://www.example.com/harga-benih-padi-2026'
        is_published = $true
    },
    @{
        title = 'Pencegahan Penyakit Busuk Batang Padi'
        content = 'Penyakit busuk batang menyebabkan kerugian hingga 30% dari panen. Pencegahan dimulai dari pemilihan bibit unggul dan manajemen air yang tepat. Ikuti panduan lengkap pengendalian organik kami.'
        category_id = 1
        link = 'https://www.example.com/pencegahan-penyakit-busuk-batang'
        is_published = $true
    }
)

foreach ($article in $articles) {
    $body = $article | ConvertTo-Json
    
    try {
        $response = Invoke-WebRequest -Uri 'http://localhost:8000/api/articles' `
            -Method POST `
            -Headers @{'Content-Type'='application/json'; 'Accept'='application/json'} `
            -Body $body `
            -UseBasicParsing
        
        $result = $response.Content | ConvertFrom-Json
        Write-Host "OK Artikel '$($result.data.title)' berhasil dibuat (ID: $($result.data.id))" -ForegroundColor Green
    } catch {
        Write-Host "ERROR Gagal membuat artikel: $($_.Exception.Message)" -ForegroundColor Red
    }
}
