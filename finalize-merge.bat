@echo off
cd /d "C:\Users\Jaffray\laporin-aja"

echo === CEK STATUS GIT ===
git status

echo.
echo === CEK MERGE STATUS ===
if exist .git\MERGE_HEAD (
    echo Merge MASIH dalam progress
    echo Menambahkan semua file yang sudah resolved...
    git add -A
    
    echo.
    echo Membuat commit finish merge...
    git commit -m "Finalize merge: resolve template conflicts (auth-dropdown, sidebar, admin-sidebar)"
    
    echo.
    echo === MERGE COMPLETE ===
    git log -3 --oneline
) else (
    echo Merge sudah selesai!
    git log -3 --oneline
)

echo.
echo === VERIFIKASI FINAL ===
git status
