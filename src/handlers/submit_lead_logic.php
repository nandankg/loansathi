<?php

require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/validator.php';

/**
 * Process a lead submission payload. Pure logic — DB is optional via $allow_storage flag.
 *
 * Returns:
 *   ['ok' => true, 'data' => [...]] on success (validated, ready-to-store payload)
 *   ['ok' => true, 'note' => 'honeypot'] when honeypot triggered (silent drop)
 *   ['ok' => false, 'code' => 'csrf'|'validation'|'rate_limit', 'errors' => [...]] on rejection
 */
function process_lead_submission(array $body, string $ip, string $ua): array {
    if (!empty($body['website'])) {
        return ['ok' => true, 'note' => 'honeypot'];
    }
    $submitted = (string)($body['_csrf'] ?? '');
    $session   = (string)($body['session_csrf'] ?? $_SESSION['_csrf'] ?? '');
    if ($submitted === '' || $session === '' || !hash_equals($session, $submitted)) {
        return ['ok' => false, 'code' => 'csrf'];
    }
    $v = validate_lead($body);
    if (!$v['ok']) {
        return ['ok' => false, 'code' => 'validation', 'errors' => $v['errors']];
    }
    $data = $v['data'];
    $data['ip_address']   = $ip;
    $data['user_agent']   = mb_substr($ua, 0, 255);
    $data['source_page']  = mb_substr((string)($body['source_page'] ?? ''), 0, 255);
    $data['utm_source']   = mb_substr((string)($body['utm_source'] ?? ''), 0, 80);
    $data['utm_medium']   = mb_substr((string)($body['utm_medium'] ?? ''), 0, 80);
    $data['utm_campaign'] = mb_substr((string)($body['utm_campaign'] ?? ''), 0, 120);
    $data['monthly_income']     = isset($body['monthly_income']) && is_numeric($body['monthly_income']) ? (float)$body['monthly_income'] : null;
    $data['employment_type']    = mb_substr((string)($body['employment_type'] ?? ''), 0, 40) ?: null;
    $data['credit_score_range'] = mb_substr((string)($body['credit_score_range'] ?? ''), 0, 20) ?: null;
    return ['ok' => true, 'data' => $data];
}

function store_lead(array $data): int {
    require_once __DIR__ . '/../lib/db.php';
    $sql = "INSERT INTO leads
        (name, phone, email, loan_type, loan_amount, city, monthly_income, employment_type,
         credit_score_range, message, source_page, source_form, utm_source, utm_medium, utm_campaign,
         ip_address, user_agent)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = db()->prepare($sql);
    $stmt->execute([
        $data['name'], $data['phone'], $data['email'] ?? null, $data['loan_type'],
        $data['loan_amount'] ?? null, $data['city'] ?? null, $data['monthly_income'] ?? null,
        $data['employment_type'] ?? null, $data['credit_score_range'] ?? null,
        $data['message'] ?? null, $data['source_page'] ?? null, $data['source_form'] ?? null,
        $data['utm_source'] ?? null, $data['utm_medium'] ?? null, $data['utm_campaign'] ?? null,
        $data['ip_address'] ?? null, $data['user_agent'] ?? null,
    ]);
    return (int)db()->lastInsertId();
}

function notify_lead_email(array $data, int $leadId): bool {
    require_once __DIR__ . '/../lib/mailer.php';
    $to = config('contact.lead_inbox');
    $subject = '[LoanSathi] New lead: ' . $data['name'] . ' — ' . $data['loan_type'];
    $admin_url = config('base_url') . '/admin/leads/' . $leadId;
    $rows = '';
    foreach ($data as $k => $v) {
        $rows .= '<tr><td style="padding:4px 8px;border:1px solid #eee"><b>' . e($k) . '</b></td><td style="padding:4px 8px;border:1px solid #eee">' . e((string)$v) . '</td></tr>';
    }
    $html = "<h2>New lead #{$leadId}</h2>"
          . "<p>View in admin: <a href=\"" . e($admin_url) . "\">" . e($admin_url) . "</a></p>"
          . "<table style=\"border-collapse:collapse;font-family:sans-serif\">{$rows}</table>";
    return send_mail($to, $subject, $html);
}
