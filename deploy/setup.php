<?php
// One-shot deployment helper. Hit this URL in your browser exactly once after
// uploading files and configuring .env, then DELETE THIS FILE.
//
// Protected by SETUP_KEY (set in .env). The key must match a query parameter:
//   https://yourdomain/setup.php?key=YOUR_SETUP_KEY
//
// Also refuses to run if an admin user already exists, so even if you forget
// to delete it, it cannot be replayed against a configured site.

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/lib/schema.php';

$expectedKey = config('setup_key');
if ($expectedKey === '' || $expectedKey === null) {
    http_response_code(503);
    exit('Setup is disabled: SETUP_KEY is not set in .env. Set it and reload.');
}

if (($_GET['key'] ?? '') !== $expectedKey) {
    http_response_code(403);
    exit('Forbidden.');
}

try {
    $hasAdmin = false;
    $tables = db()->query("SHOW TABLES LIKE 'admin_users'")->fetchAll();
    if (!empty($tables)) {
        $hasAdmin = (int)db()->query("SELECT COUNT(*) FROM admin_users")->fetchColumn() > 0;
    }
} catch (Throwable $e) {
    // The database may be empty before setup runs.
    $hasAdmin = false;
}

$step = $_SERVER['REQUEST_METHOD'] === 'POST' ? 'install' : ($hasAdmin ? 'done' : 'form');

?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>LoanSathi - Setup</title>
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

<h1>LoanSathi - Setup</h1>
<p class="lead">One-shot deployment installer. Creates DB schema and first admin user.</p>

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
          create_database_if_possible(db_config());
          $pdo = db();
          apply_loansathi_schema($pdo);

          $hash = password_hash($p, PASSWORD_BCRYPT);
          $pdo->prepare("INSERT INTO admin_users(username, password_hash, full_name) VALUES(?,?,?)")
              ->execute([$u, $hash, $n]);
          echo '<div class="ok"><strong>Done.</strong><p>Schema applied. Admin user <code>' . htmlspecialchars($u) . '</code> created.</p><p><strong>Now delete <code>public/setup.php</code></strong> from the server before you do anything else.</p></div>';
      } catch (Throwable $e) {
          echo '<div class="err">' . htmlspecialchars($e->getMessage()) . '</div>';
      }
  } else {
      echo '<div class="err">' . implode("\n", array_map('htmlspecialchars', $errors)) . '</div>';
      $step = 'form';
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
    (<code>public/setup.php</code>) from the server.
  </div>
<?php endif; ?>

</body>
</html>
