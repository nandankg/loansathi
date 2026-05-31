<?php
// Loaded automatically via composer.json autoload.files (so it runs once at startup
// in both web requests and CLI scripts like bin/install.php).
//
// Loads variables from a .env file at the project root if one exists. The .env
// file is OPTIONAL — when it's absent (e.g. local dev with all defaults), getenv()
// calls in src/config/app.php fall through to their defaults harmlessly.

if (!function_exists('loansathi_bootstrap')) {
    function loansathi_bootstrap(): void {
        static $done = false;
        if ($done) return;
        $done = true;

        $root = dirname(__DIR__);
        foreach ([$root . '/storage', $root . '/storage/logs', $root . '/storage/sessions'] as $dir) {
            if (!is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }
        }

        if (is_dir($root . '/storage/logs') && is_writable($root . '/storage/logs')) {
            ini_set('log_errors', '1');
            ini_set('error_log', $root . '/storage/logs/php-error-' . date('Y-m-d') . '.log');
        }

        $tmpDir = getenv('TMPDIR');
        $sessionDirs = [$root . '/storage/sessions', rtrim(sys_get_temp_dir(), '/\\') . '/loansathi_sessions'];
        if ($tmpDir !== false && $tmpDir !== '') {
            $sessionDirs[] = rtrim($tmpDir, '/\\') . '/loansathi_sessions';
        }
        if (PHP_OS_FAMILY === 'Windows') {
            $sessionDirs[] = 'C:/tmp/loansathi_sessions';
        }
        foreach (array_unique(array_filter($sessionDirs)) as $sessionDir) {
            if (!is_dir($sessionDir)) {
                @mkdir($sessionDir, 0775, true);
            }
            if (session_status() !== PHP_SESSION_ACTIVE && is_dir($sessionDir) && is_writable($sessionDir)) {
                ini_set('session.save_path', $sessionDir);
                break;
            }
        }

        if (file_exists($root . '/.env') && class_exists(\Dotenv\Dotenv::class)) {
            try {
                $dotenv = \Dotenv\Dotenv::createImmutable($root);
                $dotenv->safeLoad();
                // phpdotenv populates $_ENV by default but not getenv(); mirror across so
                // existing config code that uses getenv('SMTP_HOST') etc keeps working.
                foreach ($_ENV as $k => $v) {
                    if (getenv($k) === false) putenv("$k=$v");
                }
            } catch (Throwable $e) {
                error_log('[bootstrap] Could not load .env: ' . $e->getMessage());
            }
        }
    }
}

loansathi_bootstrap();
