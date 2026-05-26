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
        if (file_exists($root . '/.env') && class_exists(\Dotenv\Dotenv::class)) {
            $dotenv = \Dotenv\Dotenv::createImmutable($root);
            $dotenv->safeLoad();
            // phpdotenv populates $_ENV by default but not getenv(); mirror across so
            // existing config code that uses getenv('SMTP_HOST') etc keeps working.
            foreach ($_ENV as $k => $v) {
                if (getenv($k) === false) putenv("$k=$v");
            }
        }
    }
}

loansathi_bootstrap();
