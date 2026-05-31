<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/lib/schema.php';

$cfg = db_config();
create_database_if_possible($cfg);

$pdo = db();
apply_loansathi_schema($pdo);

echo "Schema applied.\n";

$count = (int)$pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
if ($count === 0) {
    echo "No admin user exists. Create one now? (y/n): ";
    $ans = trim(fgets(STDIN));
    if (strtolower($ans) === 'y') {
        echo "Username: ";        $u = trim(fgets(STDIN));
        echo "Full name: ";       $n = trim(fgets(STDIN));
        echo "Password: ";        $p = trim(fgets(STDIN));
        $hash = password_hash($p, PASSWORD_BCRYPT);
        $pdo->prepare("INSERT INTO admin_users(username, password_hash, full_name) VALUES(?,?,?)")
            ->execute([$u, $hash, $n]);
        echo "Admin '{$u}' created.\n";
    }
}

echo "Install complete.\n";
