#!/usr/bin/env bash
# Build a deployable release zip for Hostinger / any shared-LAMP host.
#
# Usage:  bin/build-release.sh
# Output: release/loansathi-YYYYMMDD-HHMM.zip
#
# Run this from a workstation with PHP, Composer, Node and npm installed.
# The output zip contains everything the server needs and nothing it doesn't
# (no node_modules, no .git, no tests, no dev-only composer deps).

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

STAMP="$(date +%Y%m%d-%H%M)"
NAME="loansathi-$STAMP"
OUT="release/$NAME"

echo "==> Cleaning previous release"
rm -rf release
mkdir -p "$OUT"

echo "==> Building production CSS"
npm run build

echo "==> Installing production-only PHP deps (no PHPUnit)"
# --prefer-source avoids the 7-Zip extraction bug on Windows; remove the flag
# if you're on Linux/macOS where Composer's default zip path works fine.
composer install --no-dev --optimize-autoloader --prefer-source --no-progress

echo "==> Copying application files into $OUT"
# Everything the server runs at request time
cp -R public src bin vendor storage composer.json "$OUT/"

# Deploy helpers
cp deploy/setup.php           "$OUT/public/setup.php"
cp deploy/htaccess-root       "$OUT/.htaccess"
cp deploy/htaccess-deny       "$OUT/src/.htaccess"
cp deploy/htaccess-deny       "$OUT/vendor/.htaccess"
cp deploy/htaccess-deny       "$OUT/bin/.htaccess"
cp deploy/htaccess-deny       "$OUT/storage/.htaccess"

# Carry the env template, not the real .env
cp .env.example "$OUT/.env.example"

# Strip junk that creeps in via --prefer-source
echo "==> Pruning .git directories from vendor/"
find "$OUT/vendor" -type d -name '.git' -prune -exec rm -rf {} +
echo "==> Pruning tests/docs from vendor/ to shrink the zip"
find "$OUT/vendor" -type d \( -name 'tests' -o -name 'docs' -o -name 'examples' \) -prune -exec rm -rf {} + 2>/dev/null || true
find "$OUT/vendor" -type f \( -name '*.md' -o -name '*.markdown' -o -name '.gitignore' -o -name '.gitattributes' -o -name '.travis.yml' -o -name 'phpunit.xml*' -o -name '.editorconfig' \) -delete 2>/dev/null || true

# Make sure storage/logs is writable on the server (umask 0775)
chmod -R 0775 "$OUT/storage" 2>/dev/null || true

echo "==> Creating zip (PHP ZipArchive — produces POSIX-compliant forward-slash paths)"
# PowerShell Compress-Archive on Windows writes backslash path separators which
# break extraction on Linux hosts (Hostinger). PHP's ZipArchive always writes
# forward slashes per ZIP spec.
# -d extension=zip forces the zip extension even if php-cli.ini lacks it.
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
echo " Release zip ready: release/$NAME.zip  ($SIZE_HUMAN)"
echo "================================================================"
echo
echo "Next steps:"
echo "  1. Upload release/$NAME.zip to Hostinger File Manager (~/public_html or higher)"
echo "  2. Extract the zip in place; rename loansathi-$STAMP -> the folder you want"
echo "  3. Move the extracted contents up into public_html/ (or set custom root)"
echo "  4. Copy .env.example -> .env, fill in real values"
echo "  5. Copy src/config/db.php.example -> src/config/db.php, fill in DB creds"
echo "  6. Visit https://yourdomain/setup.php?key=<SETUP_KEY> once, then DELETE setup.php"
echo
echo "Full guide: deploy/DEPLOY.md"
