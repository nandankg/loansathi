<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/rate_limit.php';

function admin_user(): ?array {
    return $_SESSION['admin_user'] ?? null;
}

function admin_require_login(): void {
    if (admin_user() === null) {
        redirect('/admin/login');
    }
    if (isset($_SESSION['admin_last_seen']) && (time() - $_SESSION['admin_last_seen']) > 7200) {
        admin_logout();
        redirect('/admin/login?expired=1');
    }
    $_SESSION['admin_last_seen'] = time();
}

function admin_attempt_login(string $username, string $password): bool {
    $ip = client_ip();
    if (!rate_limit_check($ip, 'login_fail', 5, 900)) {
        return false;
    }
    $stmt = db()->prepare("SELECT id, username, password_hash, full_name, role FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    if (!$row || !password_verify($password, $row['password_hash'])) {
        rate_limit_record($ip, 'login_fail');
        return false;
    }
    session_regenerate_id(true);
    $_SESSION['admin_user'] = [
        'id'        => (int)$row['id'],
        'username'  => $row['username'],
        'full_name' => $row['full_name'],
        'role'      => $row['role'],
    ];
    $_SESSION['admin_last_seen'] = time();
    db()->prepare("UPDATE admin_users SET last_login_at = NOW() WHERE id = ?")
        ->execute([$row['id']]);
    return true;
}

function admin_logout(): void {
    unset($_SESSION['admin_user'], $_SESSION['admin_last_seen']);
    session_regenerate_id(true);
}

function admin_is_locked_out(): bool {
    return !rate_limit_check(client_ip(), 'login_fail', 5, 900);
}
