@echo off
cd /d "c:\Users\Jaffray\laporin-aja"

echo === Checking git status ===
git status

echo.
echo === Adding resolved files ===
git add resources\views\partials\auth-dropdown.blade.php
git add resources\views\partials\sidebar.blade.php

echo.
echo === Committing merge ===
git commit -m "Resolve merge conflicts in view templates"

echo.
echo === Final status ===
git status

pause
