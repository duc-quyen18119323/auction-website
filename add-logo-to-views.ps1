# Script to add logo to all view files

$files = @(
    "resources\views\auth\register.blade.php",
    "resources\views\admin\login.blade.php",
    "resources\views\admin\dashboard.blade.php",
    "resources\views\admin\users.blade.php",
    "resources\views\admin\products.blade.php",
    "resources\views\admin\auctions.blade.php",
    "resources\views\products\index.blade.php",
    "resources\views\products\show.blade.php",
    "resources\views\products\create.blade.php",
    "resources\views\products\edit.blade.php",
    "resources\views\bids\index.blade.php",
    "resources\views\bids\history.blade.php",
    "resources\views\favorites\index.blade.php",
    "resources\views\transactions\index.blade.php",
    "resources\views\profile\edit.blade.php",
    "resources\views\admin\inbox\index.blade.php",
    "resources\views\admin\inbox\show.blade.php",
    "resources\views\admin\auctions\index.blade.php",
    "resources\views\admin\auctions\show.blade.php"
)

$logoInclude = "    @include('components.header-logo')"

foreach ($file in $files) {
    $fullPath = Join-Path $PSScriptRoot $file
    
    if (Test-Path $fullPath) {
        Write-Host "Processing: $file"
        
        $content = Get-Content $fullPath -Raw -Encoding UTF8
        
        $checkPattern = "@include\('components\.header-logo'\)"
        if ($content -notmatch $checkPattern) {
            $bodyPattern = '(<body[^>]*>)'
            if ($content -match $bodyPattern) {
                $bodyTag = $matches[1]
                $replacement = "$bodyTag`r`n$logoInclude"
                $newContent = $content -replace [regex]::Escape($bodyTag), $replacement
                Set-Content -Path $fullPath -Value $newContent -Encoding UTF8 -NoNewline
                Write-Host "  Added logo to $file" -ForegroundColor Green
            } else {
                Write-Host "  Could not find body tag in $file" -ForegroundColor Yellow
            }
        } else {
            Write-Host "  Logo already exists in $file" -ForegroundColor Cyan
        }
    } else {
        Write-Host "  File not found: $file" -ForegroundColor Red
    }
}

Write-Host "Done" -ForegroundColor Green
