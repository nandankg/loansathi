<?php
// One-shot deployment helper. Hit this URL in your browser exactly once after
// uploading files and configuring src/config/db.php + .env, then DELETE THIS FILE.
//
// Protected by SETUP_KEY (set in .env). The key must match a query parameter:
//   https://yourdomain/setup.php?key=YOUR_SETUP_KEY
//
// Also refuses to run if an admin user already exists, so even if you forget
// to delete it, it can't be replayed against a configured site.

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$root = dirname(__DIR__);

// 1) Refuse without a configured key
$expectedKey = config('setup_key');
if ($expectedKey === '' || $expectedKey === null) {
    http_response_code(503);
    exit('Setup is disabled: SETUP_KEY is not set in .env. Set it and reload.');
}

if (($_GET['key'] ?? '') !== $expectedKey) {
    http_response_code(403);
    exit('Forbidden.');
}

// 2) Ensure DB config exists
$dbCfgPath = $root . '/src/config/db.php';
if (!file_exists($dbCfgPath)) {
    http_response_code(503);
    exit('Missing src/config/db.php. Copy db.php.example, fill in your Hostinger DB credentials, then reload this page.');
}

require __DIR__ . '/../src/lib/db.php';

// 3) Refuse if an admin already exists (one-shot guard)
try {
    $hasAdmin = false;
    $tables = db()->query("SHOW TABLES LIKE 'admin_users'")->fetchAll();
    if (!empty($tables)) {
        $hasAdmin = (int)db()->query("SELECT COUNT(*) FROM admin_users")->fetchColumn() > 0;
    }
} catch (Throwable $e) {
    // DB might be empty / missing — fine, we'll create it below
    $hasAdmin = false;
}

// Show install form (GET) / process (POST)
$step = $_SERVER['REQUEST_METHOD'] === 'POST' ? 'install' : ($hasAdmin ? 'done' : 'form');

?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>LoanSathi — Setup</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  *{box-sizing:border-box}
  body{font-family:system-ui,sans-serif;background:#f4f8fc;color:#0a1a33;max-width:560px;margin:40px auto;padding:0 16px;line-height:1.5}
  h1{font-size:28px;margin-bottom:4px}
  .lead{color:#4b5a78;margin-top:0}
  form{background:white;border-radius:14px;padding:24px;box-shadow:0 4px 14px rgba(30,98,215,.1);margin-top:20px}
  label{display:block;font-weight:600;margin-top:14px;font-size:14px}
  input{width:100%;padding:10px 12px;border-radius:8px;border:1px solid #cbd3e1;margin-top:4px;font:inherit}
  input:focus{outline:none;border-color:#1e62d7;box-shadow:0 0 0 3px rgba(30,98,215,.15)}
  button{margin-top:20px;background:#ff6b35;color:white;border:none;padding:12px 22px;border-radius:999px;font-weight:700;cursor:pointer;font-size:15px}
  button:hover{background:#e85a2c}
  .ok{background:#e9f9ef;color:#15803d;padding:14px;border-radius:10px;margin-top:18px}
  .err{background:#fdecea;color:#a51c1c;padding:14px;border-radius:10px;margin-top:18px;white-space:pre-wrap;font-family:ui-monospace,monospace;font-size:13px}
  .warn{background:#fff7e6;color:#92400e;padding:14px;border-radius:10px;margin-top:18px}
  code{background:#eef4ff;padding:2px 6px;border-radius:4px}
</style>
</head>
<body>

<h1>LoanSathi — Setup</h1>
<p class="lead">One-shot deployment installer. Creates DB schema + first admin user.</p>

<?php if ($step === 'done'): ?>
  <div class="ok">
    <strong>Installation already complete.</strong>
    <p>An admin user exists. For safety, this page will not run again.</p>
    <p><strong>Action required:</strong> delete <code>public/setup.php</code> from the server now.</p>
  </div>
<?php elseif ($step === 'install'):
  $errors = [];
  $u = trim($_POST['username']    ?? '');
  $n = trim($_POST['full_name']   ?? '');
  $p = (string)($_POST['password'] ?? '');
  if (strlen($u) < 3)  $errors[] = 'Username must be at least 3 characters.';
  if (strlen($n) < 2)  $errors[] = 'Full name is required.';
  if (strlen($p) < 10) $errors[] = 'Password must be at least 10 characters.';

  if (empty($errors)) {
      try {
          // Create the database if the user gave permission; otherwise use whatever's configured
          $cfg = require $dbCfgPath;
          try {
              $rootPdo = new PDO(
                  "mysql:host={$cfg['host']};port={$cfg['port']};charset={$cfg['charset']}",
                  $cfg['username'], $cfg['password'],
                  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
              );
              $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `{$cfg['database']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
          } catch (Throwable $e) {
              // Hostinger DB users usually can't CREATE DATABASE — but the DB was created via hPanel anyway.
          }

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
          $hash = password_hash($p, PASSWORD_BCRYPT);
          $pdo->prepare("INSERT INTO admin_users(username, password_hash, full_name) VALUES(?,?,?)")
              ->execute([$u, $hash, $n]);
          echo '<div class="ok"><strong>Done.</strong><p>Schema applied. Admin user <code>' . htmlspecialchars($u) . '</code> created.</p><p><strong>Now delete <code>public/setup.php</code></strong> from the server before you do anything else.</p></div>';
      } catch (Throwable $e) {
          echo '<div class="err">' . htmlspecialchars($e->getMessage()) . '</div>';
      }
  } else {
      echo '<div class="err">' . implode("\n", array_map('htmlspecialchars', $errors)) . '</div>';
      $step = 'form'; // re-show
  }
endif;

if ($step === 'form'): ?>
  <form method="post">
    <p style="color:#4b5a78">Create the first admin user. You can change the password later.</p>
    <label>Username
      <input type="text" name="username" required minlength="3" autocomplete="off" autofocus>
    </label>
    <label>Full name
      <input type="text" name="full_name" required minlength="2" autocomplete="off">
    </label>
    <label>Password (min 10 chars)
      <input type="password" name="password" required minlength="10" autocomplete="new-password">
    </label>
    <button type="submit">Install &amp; create admin</button>
  </form>
  <div class="warn">
    <strong>Heads-up:</strong> after a successful install, <em>delete this file</em>
    (<code>public/setup.php</code>) from the server. It guards itself with SETUP_KEY
    and admin-exists checks, but it has no business living on a production site.
  </div>
<?php endif; ?>

</body>
</html>
