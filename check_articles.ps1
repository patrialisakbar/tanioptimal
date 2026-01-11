$response = Invoke-WebRequest -Uri 'http://localhost:8000/api/articles' -UseBasicParsing
$data = $response.Content | ConvertFrom-Json

Write-Host "Total Artikel: $($data.data.Count)" -ForegroundColor Green
Write-Host "`nDaftar Artikel dengan Link:" -ForegroundColor Green

$data.data | ForEach-Object {
    Write-Host "[$($_.id)] $($_.title)" -ForegroundColor Cyan
    Write-Host "    Category: $($_.category_id) | Link: $($_.link)" -ForegroundColor Gray
}
