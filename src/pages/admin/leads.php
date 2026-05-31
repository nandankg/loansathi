<?php
require_once __DIR__ . '/../../lib/auth.php';
require_once __DIR__ . '/../../lib/db.php';

admin_require_login();

$statuses = ['new', 'contacted', 'qualified', 'disbursed', 'rejected', 'spam'];
$status = (string)($_GET['status'] ?? '');
$q = trim((string)($_GET['q'] ?? ''));
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

$where = [];
$params = [];
if (in_array($status, $statuses, true)) {
    $where[] = 'status = ?';
    $params[] = $status;
}
if ($q !== '') {
    $where[] = '(name LIKE ? OR phone LIKE ? OR email LIKE ? OR city LIKE ?)';
    $like = '%' . $q . '%';
    array_push($params, $like, $like, $like, $like);
}
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$countStmt = db()->prepare("SELECT COUNT(*) FROM leads {$whereSql}");
$countStmt->execute($params);
$total = (int)$countStmt->fetchColumn();

$stmt = db()->prepare(
    "SELECT id, name, phone, email, loan_type, loan_amount, city, status, created_at
     FROM leads {$whereSql}
     ORDER BY created_at DESC
     LIMIT {$perPage} OFFSET {$offset}"
);
$stmt->execute($params);
$leads = $stmt->fetchAll();
$totalPages = max(1, (int)ceil($total / $perPage));

$page_title = 'Leads - LoanSathi Admin';
$page_robots = 'noindex,nofollow';
require __DIR__ . '/../../partials/header.php';
?>

<section class="bg-surface-100 py-10 lg:py-14">
  <div class="container-page">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
      <div>
        <p class="eyebrow">Admin</p>
        <h1 class="mt-2 font-display text-4xl font-extrabold text-ink">Leads</h1>
        <p class="mt-2 text-ink-500"><?= e((string)$total) ?> matching lead<?= $total === 1 ? '' : 's' ?></p>
      </div>
      <a href="/admin/logout" class="btn-secondary">Sign out</a>
    </div>

    <form method="get" class="mt-8 card">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <div class="md:col-span-7">
          <label class="text-xs uppercase tracking-wider font-extrabold text-ink-500" for="q">Search</label>
          <input id="q" name="q" value="<?= e($q) ?>" class="input-field mt-2" placeholder="Name, phone, email, or city">
        </div>
        <div class="md:col-span-3">
          <label class="text-xs uppercase tracking-wider font-extrabold text-ink-500" for="status">Status</label>
          <select id="status" name="status" class="input-field mt-2">
            <option value="">All statuses</option>
            <?php foreach ($statuses as $s): ?>
              <option value="<?= e($s) ?>" <?= $status === $s ? 'selected' : '' ?>><?= e(ucfirst($s)) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="md:col-span-2 flex items-end">
          <button class="btn-primary w-full !justify-center" type="submit">Filter</button>
        </div>
      </div>
    </form>

    <div class="mt-6 card overflow-hidden p-0">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-white text-ink-500 uppercase text-[11px] tracking-wider">
            <tr>
              <th class="text-left px-5 py-4 font-extrabold">Lead</th>
              <th class="text-left px-5 py-4 font-extrabold">Loan</th>
              <th class="text-left px-5 py-4 font-extrabold">Status</th>
              <th class="text-left px-5 py-4 font-extrabold">Created</th>
              <th class="px-5 py-4"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-ink/5 bg-white">
            <?php if (!$leads): ?>
              <tr><td colspan="5" class="px-5 py-10 text-center text-ink-500">No leads found.</td></tr>
            <?php endif; ?>
            <?php foreach ($leads as $lead): ?>
              <tr class="hover:bg-surface-100">
                <td class="px-5 py-4">
                  <div class="font-extrabold text-ink"><?= e($lead['name']) ?></div>
                  <div class="mt-1 text-xs text-ink-500 nums"><?= e($lead['phone']) ?><?= $lead['email'] ? ' - ' . e($lead['email']) : '' ?></div>
                  <?php if ($lead['city']): ?><div class="mt-1 text-xs text-ink-400"><?= e($lead['city']) ?></div><?php endif; ?>
                </td>
                <td class="px-5 py-4">
                  <div class="font-bold text-ink"><?= e(config('loan_types.' . $lead['loan_type'], $lead['loan_type'])) ?></div>
                  <?php if ($lead['loan_amount']): ?><div class="mt-1 text-xs text-ink-500 nums">Rs <?= e(number_format((float)$lead['loan_amount'])) ?></div><?php endif; ?>
                </td>
                <td class="px-5 py-4">
                  <span class="inline-flex rounded-full bg-brand-50 px-3 py-1 text-xs font-extrabold text-brand-700"><?= e(ucfirst($lead['status'])) ?></span>
                </td>
                <td class="px-5 py-4 text-ink-500 nums"><?= e(date('d M Y, h:i A', strtotime($lead['created_at']))) ?></td>
                <td class="px-5 py-4 text-right">
                  <a class="text-brand-500 font-extrabold hover:text-brand-700" href="/admin/leads/<?= e((string)$lead['id']) ?>">Open</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <?php if ($totalPages > 1): ?>
      <div class="mt-6 flex items-center justify-between text-sm">
        <a class="btn-secondary <?= $page <= 1 ? 'pointer-events-none opacity-50' : '' ?>" href="/admin/leads?<?= e(http_build_query(['q' => $q, 'status' => $status, 'page' => max(1, $page - 1)])) ?>">Previous</a>
        <span class="font-bold text-ink-500">Page <?= e((string)$page) ?> of <?= e((string)$totalPages) ?></span>
        <a class="btn-secondary <?= $page >= $totalPages ? 'pointer-events-none opacity-50' : '' ?>" href="/admin/leads?<?= e(http_build_query(['q' => $q, 'status' => $status, 'page' => min($totalPages, $page + 1)])) ?>">Next</a>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/../../partials/footer.php'; ?>
