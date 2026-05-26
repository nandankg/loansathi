<?php

require_once __DIR__ . '/db.php';

/**
 * Check whether the IP has exceeded $limit events of $type in the last $windowSeconds.
 * Returns true if within limit (allowed), false if blocked.
 */
function rate_limit_check(string $ip, string $type, int $limit, int $windowSeconds): bool {
    $stmt = db()->prepare(
        "SELECT COUNT(*) FROM rate_limit_log
         WHERE ip_address = ? AND event_type = ?
           AND submitted_at >= (NOW() - INTERVAL ? SECOND)"
    );
    $stmt->execute([$ip, $type, $windowSeconds]);
    return ((int)$stmt->fetchColumn()) < $limit;
}

function rate_limit_record(string $ip, string $type): void {
    db()->prepare("INSERT INTO rate_limit_log(ip_address, event_type) VALUES(?, ?)")
        ->execute([$ip, $type]);
}

function rate_limit_prune(): void {
    db()->exec("DELETE FROM rate_limit_log WHERE submitted_at < (NOW() - INTERVAL 7 DAY)");
}
