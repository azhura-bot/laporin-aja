#!/bin/bash
cd "/c/Users/Jaffray/laporin-aja"

echo "=== STATUS GIT SAAT INI ==="
git status

echo ""
echo "=== CEK APAKAH ADA FILE YANG BELUM RESOLVED ==="
if git diff --name-only --diff-filter=U | grep -q .; then
  echo "❌ Masih ada file dengan conflict: "
  git diff --name-only --diff-filter=U
else
  echo "✅ Semua conflict sudah resolved!"
fi

echo ""
echo "=== LOG COMMIT TERAKHIR ==="
git log -5 --oneline

echo ""
echo "=== CEK MERGE STATUS ==="
if [ -f .git/MERGE_HEAD ]; then
  echo "⚠️ Merge masih dalam progress, perlu di-complete"
  cat .git/MERGE_HEAD
else
  echo "✅ Merge sudah selesai"
fi
