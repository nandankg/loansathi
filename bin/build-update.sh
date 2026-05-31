#!/usr/bin/env bash
# Build a small INCREMENTAL update zip for Hostinger / shared LAMP hosting.
#
# Ships only the application files that changed since a given git ref, plus a
# freshly compiled stylesheet (so Tailwind class changes always ride along).
# Use this for quick PHP / template / CSS updates between full releases.
#
# Usage:
#   bin/build-update.sh [BASE_REF]
#       BASE_REF defaults to the previous commit (HEAD~1).
#       Examples:
#         bin/build-update.sh                # changes in the last commit
#         bin/build-update.sh v1.2.0         # changes since a tag
#         bin/build-update.sh origin/main    # changes since the deployed ref
#
# Env:
#   SKIP_CSS=1   skip the `npm run build` step (use the existing site.css)
#
# Output: release/loansathi-update-YYYYMMDD-HHMM.zip
#
# IMPORTANT: this incremental zip does NOT contain vendor/. If composer
# dependencies changed (composer.json / composer.lock / vendor/), build and
# upload a full release with bin/build-release.sh instead.

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

BASE_REF="${1:-HEAD~1}"
SKIP_CSS="${SKIP_CSS:-0}"

if ! git rev-parse --verify --quiet "$BASE_REF" >/dev/null; then
  echo "ERROR: git ref '$BASE_REF' not found." >&2
  exit 1
fi

STAMP="$(date +%Y%m%d-%H%M)"
NAME="loansathi-update-$STAMP"
OUT="release/$NAME"

echo "==> Incremental update since: $BASE_REF"

# Warn (don't block) if dependency manifests changed — vendor/ isn't shipped here.
if git diff --name-only "$BASE_REF" -- composer.json composer.lock | grep -q .; then
  echo "!!  composer.json/lock changed since $BASE_REF."
  echo "!!  vendor/ is NOT included in an incremental zip — run bin/build-release.sh"
  echo "!!  for a full release if production dependencies changed."
fi

# Collect changed, still-present, deployable app files (Added/Copied/Modified/Renamed).
# Scope to runtime paths; never ship the optional PHP db config.
mapfile -t FILES < <(
  git diff --name-only --diff-filter=ACMR "$BASE_REF" -- public src composer.json .env.example \
    | grep -vE '^src/config/db\.php$' || true
)

# Rebuild CSS and always include the compiled stylesheet, so any Tailwind class
# used by changed templates is present even though site.css may be gitignored.
if [ "$SKIP_CSS" != "1" ]; then
  echo "==> Building production CSS"
  npm run build
else
  echo "==> SKIP_CSS=1 — using existing public/assets/css/site.css"
fi
if [ -f public/assets/css/site.css ]; then
  FILES+=("public/assets/css/site.css")
fi

# De-duplicate the file list.
mapfile -t FILES < <(printf '%s\n' "${FILES[@]}" | awk 'NF' | sort -u)

if [ "${#FILES[@]}" -eq 0 ]; then
  echo "No deployable app files changed since $BASE_REF. Nothing to package."
  exit 0
fi

echo "==> Files to package (${#FILES[@]}):"
printf '    %s\n' "${FILES[@]}"

echo "==> Staging into $OUT"
rm -rf "$OUT" "$OUT.zip"
mkdir -p "$OUT"
for f in "${FILES[@]}"; do
  if [ -f "$f" ]; then
    mkdir -p "$OUT/$(dirname "$f")"
    cp "$f" "$OUT/$f"
  fi
done

# Surface deletions — the server copy must be removed by hand (a copy-based
# incremental upload cannot delete files for you).
DELETED="$(git diff --name-only --diff-filter=D "$BASE_REF" -- public src || true)"
if [ -n "$DELETED" ]; then
  echo "==> NOTE: files deleted since $BASE_REF (remove these on the server manually):"
  printf '    %s\n' $DELETED
fi

echo "==> Creating zip (PHP ZipArchive — POSIX forward-slash paths for Linux hosts)"
php -d extension=zip -r '
$src = $argv[1];
$dst = $argv[2];
$zip = new ZipArchive();
if ($zip->open($dst, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    fwrite(STDERR, "Failed to open $dst\n"); exit(1);
}
$rii = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($src, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);
$srcLen = strlen(realpath($src)) + 1;
$count = 0;
foreach ($rii as $file) {
    $abs = $file->getPathname();
    $rel = str_replace("\\", "/", substr(realpath($abs), $srcLen));
    if ($file->isDir()) {
        $zip->addEmptyDir($rel);
    } else {
        $zip->addFile($abs, $rel);
        $count++;
    }
}
$zip->close();
fwrite(STDOUT, "Wrote $count files\n");
' "$ROOT/release/$NAME" "$ROOT/release/$NAME.zip"

SIZE_HUMAN=$(du -h "release/$NAME.zip" | cut -f1)
echo
echo "================================================================"
echo " Update zip ready: release/$NAME.zip  ($SIZE_HUMAN)"
echo "================================================================"
echo
echo "Upload steps (Hostinger File Manager):"
echo "  1. Open public_html/ (or your app root)."
echo "  2. Upload release/$NAME.zip and 'Extract' it IN PLACE."
echo "     The zip keeps public/ and src/ paths, so files land in the right"
echo "     folders and overwrite the old versions."
echo "  3. If composer.json or .env.example changed, reconcile them on the"
echo "     server (and set any new .env values)."
echo "  4. Hard-refresh the site to pick up the new CSS."
echo
echo "For dependency changes or a clean full deploy, use bin/build-release.sh."
