<?php

if (!function_exists('config')) {
    function config(?string $key = null, $default = null) {
        static $cfg = null;
        if ($cfg === null) {
            $cfg = require __DIR__ . '/../config/app.php';
        }
        if ($key === null) return $cfg;
        $parts = explode('.', $key);
        $val = $cfg;
        foreach ($parts as $p) {
            if (!is_array($val) || !array_key_exists($p, $val)) return $default;
            $val = $val[$p];
        }
        return $val;
    }
}

if (!function_exists('e')) {
    function e($value): string {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('base_url')) {
    function base_url(string $path = ''): string {
        $base = rtrim(config('base_url'), '/');
        // Guard against a scheme-less BASE_URL (e.g. "example.com/") in .env. Without
        // a scheme the browser treats asset URLs as relative and doubles the domain
        // (https://example.com/example.com/assets/...), so force one.
        if ($base !== '' && !preg_match('#^https?://#i', $base)) {
            $base = 'https://' . ltrim($base, '/');
        }
        return $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string {
        return base_url('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url, int $status = 302): void {
        header('Location: ' . $url, true, $status);
        exit;
    }
}

if (!function_exists('json_response')) {
    function json_response($data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}

if (!function_exists('client_ip')) {
    function client_ip(): string {
        $raw = $_SERVER['HTTP_CF_CONNECTING_IP']
            ?? $_SERVER['HTTP_X_REAL_IP']
            ?? $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['REMOTE_ADDR']
            ?? '0.0.0.0';
        $ip = trim(explode(',', (string)$raw)[0]);
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }
}
