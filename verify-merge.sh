#!/bin/bash
cd "c:/Users/Jaffray/laporin-aja"
echo "=== Verifying merge completion ==="
git log -1 --oneline
echo ""
echo "=== Current branch ==="
git branch
echo ""
echo "=== Merge status ==="
if git diff --name-only --diff-filter=U | grep -q .; then
  echo "❌ Conflicts still exist:"
  git diff --name-only --diff-filter=U
else
  echo "✅ No unresolved conflicts!"
fi
