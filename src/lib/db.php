<?php

function db(): PDO {
    static $pdo = null;
    if ($pdo !== null) return $pdo;

    $cfgPath = __DIR__ . '/../config/db.php';
    if (!file_exists($cfgPath)) {
        throw new RuntimeException('Missing src/config/db.php. Copy db.php.example and configure.');
    }
    $c = require $cfgPath;
    $dsn = "mysql:host={$c['host']};port={$c['port']};dbname={$c['database']};charset={$c['charset']}";
    $pdo = new PDO($dsn, $c['username'], $c['password'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    return $pdo;
}
