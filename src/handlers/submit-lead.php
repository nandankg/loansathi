<?php

require_once __DIR__ . '/../lib/csrf.php';
require_once __DIR__ . '/../lib/rate_limit.php';
require_once __DIR__ . '/submit_lead_logic.php';

header('Content-Type: application/json');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    json_response(['ok' => false, 'code' => 'method'], 405);
}

$raw = file_get_contents('php://input') ?: '';
$body = json_decode($raw, true) ?: [];
$body['session_csrf'] = $_SESSION['_csrf'] ?? '';

$ip = client_ip();
$ua = (string)($_SERVER['HTTP_USER_AGENT'] ?? '');

if (!rate_limit_check($ip, 'form_submit', 5, 3600)) {
    json_response(['ok' => false, 'code' => 'rate_limit', 'message' => 'Too many submissions. Please try again later.'], 429);
}

$result = process_lead_submission($body, $ip, $ua);

if (!empty($result['note']) && $result['note'] === 'honeypot') {
    json_response(['ok' => true, 'message' => 'Thanks.']);
}

if (!$result['ok']) {
    $status = $result['code'] === 'csrf' ? 403 : 422;
    json_response($result, $status);
}

try {
    $leadId = store_lead($result['data']);
    rate_limit_record($ip, 'form_submit');
    notify_lead_email($result['data'], $leadId);
    json_response(['ok' => true, 'message' => "Thanks, we'll be in touch within 24 hours.", 'lead_id' => $leadId]);
} catch (Throwable $ex) {
    error_log('[submit-lead] DB error: ' . $ex->getMessage());
    json_response(['ok' => false, 'code' => 'server', 'message' => 'Something went wrong. Please try again.'], 500);
}
