$body = @{
    title = 'Panduan Lengkap Budidaya Padi Organik'
    content = 'Padi organik semakin diminati oleh petani modern karena harga yang lebih tinggi. Artikel ini membahas seluruh proses budidaya dari persiapan lahan hingga panen padi organik berkualitas tinggi dengan sistem pertanian berkelanjutan.'
    category_id = 2
    link = 'https://www.tanioptimal.com/budidaya-padi-organik'
    is_published = $true
} | ConvertTo-Json

try {
    $response = Invoke-WebRequest -Uri 'http://localhost:8000/api/articles' `
        -Method POST `
        -Headers @{'Content-Type'='application/json'; 'Accept'='application/json'} `
        -Body $body `
        -UseBasicParsing
    
    Write-Host "Status Code: $($response.StatusCode)" -ForegroundColor Green
    Write-Host "Response:" -ForegroundColor Green
    $result = $response.Content | ConvertFrom-Json
    Write-Host "Article ID: $($result.data.id)" -ForegroundColor Cyan
    Write-Host "Title: $($result.data.title)" -ForegroundColor Cyan
    Write-Host "Link: $($result.data.link)" -ForegroundColor Cyan
} catch {
    Write-Host "Status Code: $($_.Exception.Response.StatusCode.value__)" -ForegroundColor Red
    Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
}
