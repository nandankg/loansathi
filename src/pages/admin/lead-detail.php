<?php
require_once __DIR__ . '/../../lib/auth.php';
require_once __DIR__ . '/../../lib/csrf.php';
require_once __DIR__ . '/../../lib/db.php';

admin_require_login();

$id = (int)($GLOBALS['route_params']['id'] ?? 0);
$statuses = ['new', 'contacted', 'qualified', 'disbursed', 'rejected', 'spam'];
$notice = '';
$error = '';

if ($id <= 0) {
    http_response_code(404);
    require __DIR__ . '/../404.php';
    return;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!csrf_validate((string)($_POST['_csrf'] ?? ''))) {
        $error = 'Security check failed. Please refresh and try again.';
    } else {
        $newStatus = (string)($_POST['status'] ?? 'new');
        $notes = trim((string)($_POST['admin_notes'] ?? ''));
        if (!in_array($newStatus, $statuses, true)) {
            $error = 'Invalid status.';
        } else {
            $stmt = db()->prepare('UPDATE leads SET status = ?, admin_notes = ? WHERE id = ?');
            $stmt->execute([$newStatus, $notes !== '' ? $notes : null, $id]);
            $notice = 'Lead updated.';
        }
    }
}

$stmt = db()->prepare('SELECT * FROM leads WHERE id = ?');
$stmt->execute([$id]);
$lead = $stmt->fetch();
if (!$lead) {
    http_response_code(404);
    require __DIR__ . '/../404.php';
    return;
}

$fields = [
    'Name' => $lead['name'],
    'Phone' => $lead['phone'],
    'Email' => $lead['email'],
    'Loan type' => config('loan_types.' . $lead['loan_type'], $lead['loan_type']),
    'Loan amount' => $lead['loan_amount'] ? 'Rs ' . number_format((float)$lead['loan_amount']) : '',
    'City' => $lead['city'],
    'Monthly income' => $lead['monthly_income'] ? 'Rs ' . number_format((float)$lead['monthly_income']) : '',
    'Employment type' => $lead['employment_type'],
    'Credit score' => $lead['credit_score_range'],
    'Message' => $lead['message'],
    'Source page' => $lead['source_page'],
    'Source form' => $lead['source_form'],
    'UTM source' => $lead['utm_source'],
    'UTM medium' => $lead['utm_medium'],
    'UTM campaign' => $lead['utm_campaign'],
    'IP address' => $lead['ip_address'],
    'User agent' => $lead['user_agent'],
    'Created' => date('d M Y, h:i A', strtotime($lead['created_at'])),
];

$page_title = 'Lead #' . $id . ' - LoanSathi Admin';
$page_robots = 'noindex,nofollow';
require __DIR__ . '/../../partials/header.php';
?>

<section class="bg-surface-100 py-10 lg:py-14">
  <div class="container-page">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
      <div>
        <a href="/admin/leads" class="text-brand-500 text-sm font-extrabold hover:text-brand-700">Back to leads</a>
        <h1 class="mt-2 font-display text-4xl font-extrabold text-ink">Lead #<?= e((string)$id) ?></h1>
        <p class="mt-2 text-ink-500"><?= e($lead['name']) ?> - <?= e(config('loan_types.' . $lead['loan_type'], $lead['loan_type'])) ?></p>
      </div>
      <div class="flex gap-2">
        <a href="tel:<?= e($lead['phone']) ?>" class="btn-primary">Call</a>
        <a href="https://wa.me/<?= e(preg_replace('/\D+/', '', $lead['phone'])) ?>" target="_blank" rel="noopener" class="btn-secondary">WhatsApp</a>
      </div>
    </div>

    <?php if ($notice !== ''): ?>
      <div class="mt-6 rounded-xl bg-success-50 text-success-600 p-4 text-sm font-semibold"><?= e($notice) ?></div>
    <?php endif; ?>
    <?php if ($error !== ''): ?>
      <div class="mt-6 rounded-xl bg-red-50 text-red-700 p-4 text-sm font-semibold"><?= e($error) ?></div>
    <?php endif; ?>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-2 card">
        <h2 class="font-display text-2xl font-extrabold text-ink">Lead details</h2>
        <dl class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
          <?php foreach ($fields as $label => $value): ?>
            <?php if ($value === null || $value === '') continue; ?>
            <div class="<?= in_array($label, ['Message', 'User agent'], true) ? 'md:col-span-2' : '' ?>">
              <dt class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500"><?= e($label) ?></dt>
              <dd class="mt-1 text-ink font-semibold break-words"><?= nl2br(e($value)) ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>
      </div>

      <aside class="card">
        <h2 class="font-display text-2xl font-extrabold text-ink">Update</h2>
        <form method="post" class="mt-6 space-y-4">
          <?= csrf_field() ?>
          <div>
            <label class="text-xs uppercase tracking-wider font-extrabold text-ink-500" for="status">Status</label>
            <select id="status" name="status" class="input-field mt-2">
              <?php foreach ($statuses as $s): ?>
                <option value="<?= e($s) ?>" <?= $lead['status'] === $s ? 'selected' : '' ?>><?= e(ucfirst($s)) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="text-xs uppercase tracking-wider font-extrabold text-ink-500" for="admin_notes">Admin notes</label>
            <textarea id="admin_notes" name="admin_notes" rows="8" class="input-field mt-2"><?= e($lead['admin_notes'] ?? '') ?></textarea>
          </div>
          <button type="submit" class="btn-primary w-full !justify-center">Save changes</button>
        </form>
      </aside>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../../partials/footer.php'; ?>
