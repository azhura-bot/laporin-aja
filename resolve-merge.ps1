# PowerShell script to resolve merge conflicts
Set-Location "c:\Users\Jaffray\laporin-aja"

Write-Host "=== Checking git status ===" -ForegroundColor Green
git status

Write-Host "`n=== Checking for remaining conflicts ===" -ForegroundColor Green
git diff --name-only --diff-filter=U

Write-Host "`n=== Adding all resolved files ===" -ForegroundColor Green
git add resources/views/partials/auth-dropdown.blade.php resources/views/partials/sidebar.blade.php

Write-Host "`n=== Status after adding ===" -ForegroundColor Green
git status

Write-Host "`n=== Completing merge ===" -ForegroundColor Green
git commit -m "Resolve merge conflicts in view templates"

Write-Host "`n=== Final status ===" -ForegroundColor Green
git status
