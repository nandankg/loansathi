<?php
require_once __DIR__ . '/../../lib/auth.php';
require_once __DIR__ . '/../../lib/csrf.php';

if (admin_user() !== null) {
    redirect('/admin/leads');
}

$error = '';
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!csrf_validate((string)($_POST['_csrf'] ?? ''))) {
        $error = 'Security check failed. Please refresh and try again.';
    } elseif (admin_attempt_login(trim((string)($_POST['username'] ?? '')), (string)($_POST['password'] ?? ''))) {
        redirect('/admin/leads');
    } else {
        $error = admin_is_locked_out()
            ? 'Too many failed attempts. Please try again in 15 minutes.'
            : 'Invalid username or password.';
    }
}

$page_title = 'Admin login - LoanSathi';
$page_robots = 'noindex,nofollow';
require __DIR__ . '/../../partials/header.php';
?>

<section class="bg-surface-100 py-16 lg:py-24">
  <div class="container-tight max-w-md">
    <div class="card">
      <p class="eyebrow">Admin</p>
      <h1 class="mt-3 font-display text-3xl font-extrabold text-ink">Sign in</h1>
      <?php if (($_GET['expired'] ?? '') === '1'): ?>
        <div class="mt-5 rounded-xl bg-accent-50 text-accent-700 p-4 text-sm font-semibold">Your session expired. Please sign in again.</div>
      <?php endif; ?>
      <?php if ($error !== ''): ?>
        <div class="mt-5 rounded-xl bg-red-50 text-red-700 p-4 text-sm font-semibold"><?= e($error) ?></div>
      <?php endif; ?>
      <form method="post" class="mt-6 space-y-4">
        <?= csrf_field() ?>
        <div>
          <label class="text-sm font-extrabold text-ink" for="username">Username</label>
          <input id="username" name="username" class="input-field mt-2" required autocomplete="username">
        </div>
        <div>
          <label class="text-sm font-extrabold text-ink" for="password">Password</label>
          <input id="password" name="password" type="password" class="input-field mt-2" required autocomplete="current-password">
        </div>
        <button class="btn-primary w-full !justify-center" type="submit">Sign in</button>
      </form>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../../partials/footer.php'; ?>
