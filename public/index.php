<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/lib/router.php';

$isProd = (getenv('APP_ENV') === 'production');
error_reporting(E_ALL);
ini_set('display_errors', $isProd ? '0' : '1');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../storage/logs/php-error-' . date('Y-m-d') . '.log');

ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
if (($_SERVER['HTTPS'] ?? '') === 'on') {
    ini_set('session.cookie_secure', '1');
}
session_start();

try {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    route($path);
} catch (Throwable $ex) {
    error_log('[uncaught] ' . $ex->getMessage() . "\n" . $ex->getTraceAsString());
    http_response_code(500);
    if ($isProd) {
        require __DIR__ . '/../src/pages/500.php';
    } else {
        echo '<pre>' . htmlspecialchars((string)$ex) . '</pre>';
    }
    exit;
}
