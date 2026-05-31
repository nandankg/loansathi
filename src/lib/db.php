<?php

function db_env(string $key, ?string $default = null): ?string {
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }
    return $value;
}

function db_config(): array {
    $cfgPath = __DIR__ . '/../config/db.php';
    $fileConfig = file_exists($cfgPath) ? require $cfgPath : [];

    $cfg = [
        'host'     => $fileConfig['host']     ?? db_env('DB_HOST', '127.0.0.1'),
        'port'     => (int)($fileConfig['port'] ?? db_env('DB_PORT', '3306')),
        'database' => $fileConfig['database'] ?? db_env('DB_DATABASE', ''),
        'username' => $fileConfig['username'] ?? db_env('DB_USERNAME', ''),
        'password' => $fileConfig['password'] ?? db_env('DB_PASSWORD', ''),
        'charset'  => $fileConfig['charset']  ?? db_env('DB_CHARSET', 'utf8mb4'),
    ];

    if ($cfg['database'] === '' || $cfg['username'] === '') {
        throw new RuntimeException('Database is not configured. Set DB_DATABASE and DB_USERNAME in .env, or create src/config/db.php from db.php.example.');
    }

    return $cfg;
}

function db_quote_identifier(string $identifier): string {
    return '`' . str_replace('`', '``', $identifier) . '`';
}

function db(): PDO {
    static $pdo = null;
    if ($pdo !== null) return $pdo;

    $c = db_config();
    $dsn = "mysql:host={$c['host']};port={$c['port']};dbname={$c['database']};charset={$c['charset']}";
    $pdo = new PDO($dsn, $c['username'], $c['password'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    return $pdo;
}
