<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/lib/db.php';

$cfg = require __DIR__ . '/../src/config/db.php';

$rootPdo = new PDO(
    "mysql:host={$cfg['host']};port={$cfg['port']};charset={$cfg['charset']}",
    $cfg['username'], $cfg['password'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
$rootPdo->exec("CREATE DATABASE IF NOT EXISTS `{$cfg['database']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

$pdo = db();

$schema = <<<SQL
CREATE TABLE IF NOT EXISTS leads (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  email VARCHAR(180),
  loan_type VARCHAR(40) NOT NULL,
  loan_amount DECIMAL(14,2),
  city VARCHAR(80),
  monthly_income DECIMAL(12,2),
  employment_type VARCHAR(40),
  credit_score_range VARCHAR(20),
  message TEXT,
  source_page VARCHAR(255),
  source_form VARCHAR(40),
  utm_source VARCHAR(80),
  utm_medium VARCHAR(80),
  utm_campaign VARCHAR(120),
  ip_address VARCHAR(45),
  user_agent VARCHAR(255),
  status ENUM('new','contacted','qualified','disbursed','rejected','spam') DEFAULT 'new',
  admin_notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_status (status),
  INDEX idx_created (created_at),
  INDEX idx_loan_type (loan_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS admin_users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(60) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  full_name VARCHAR(120),
  role ENUM('admin','editor') DEFAULT 'admin',
  last_login_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS posts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(200) UNIQUE NOT NULL,
  title VARCHAR(200) NOT NULL,
  excerpt VARCHAR(300),
  body MEDIUMTEXT NOT NULL,
  cover_image VARCHAR(255),
  category VARCHAR(40),
  meta_title VARCHAR(70),
  meta_description VARCHAR(170),
  status ENUM('draft','published') DEFAULT 'draft',
  published_at TIMESTAMP NULL,
  author_id INT UNSIGNED,
  view_count INT UNSIGNED DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (author_id) REFERENCES admin_users(id) ON DELETE SET NULL,
  INDEX idx_status_pub (status, published_at),
  INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS rate_limit_log (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ip_address VARCHAR(45) NOT NULL,
  event_type ENUM('form_submit','login_fail') NOT NULL,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ip_type_time (ip_address, event_type, submitted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;

foreach (explode(';', $schema) as $stmt) {
    $stmt = trim($stmt);
    if ($stmt !== '') $pdo->exec($stmt);
}

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
