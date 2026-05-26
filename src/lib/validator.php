<?php

function is_valid_phone(string $phone): bool {
    $digits = preg_replace('/\D/', '', $phone);
    if (str_starts_with($digits, '91') && strlen($digits) === 12) {
        $digits = substr($digits, 2);
    }
    return (bool)preg_match('/^[6-9]\d{9}$/', $digits);
}

function is_valid_email(string $email): bool {
    if ($email === '') return false;
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function is_valid_name(string $name): bool {
    $name = trim($name);
    if (strlen($name) < 2 || strlen($name) > 120) return false;
    return (bool)preg_match("/[A-Za-z\x{0900}-\x{097F}]/u", $name);
}

function validate_lead(array $data): array {
    $errors = [];
    $cfg = require __DIR__ . '/../config/app.php';
    $allowed_loan_types = array_keys($cfg['loan_types']);

    $name = trim($data['name'] ?? '');
    if (!is_valid_name($name))   $errors['name']  = 'Please enter your full name.';

    $phone = trim($data['phone'] ?? '');
    if (!is_valid_phone($phone)) $errors['phone'] = 'Please enter a valid 10-digit Indian mobile number.';

    $email = trim($data['email'] ?? '');
    if ($email !== '' && !is_valid_email($email)) $errors['email'] = 'Email looks invalid.';

    $loan_type = trim($data['loan_type'] ?? '');
    if (!in_array($loan_type, $allowed_loan_types, true)) {
        $errors['loan_type'] = 'Please pick a loan type.';
    }

    $loan_amount = $data['loan_amount'] ?? null;
    if ($loan_amount !== null && $loan_amount !== '') {
        if (!is_numeric($loan_amount) || (float)$loan_amount < 0) {
            $errors['loan_amount'] = 'Enter a positive amount.';
        } else {
            $loan_amount = (float)$loan_amount;
        }
    } else {
        $loan_amount = null;
    }

    if (!empty($errors)) return ['ok' => false, 'errors' => $errors];

    return ['ok' => true, 'data' => [
        'name'        => $name,
        'phone'       => $phone,
        'email'       => $email !== '' ? $email : null,
        'loan_type'   => $loan_type,
        'loan_amount' => $loan_amount,
        'city'        => trim($data['city'] ?? '') ?: null,
        'message'     => trim($data['message'] ?? '') ?: null,
        'source_form' => trim($data['source_form'] ?? '') ?: 'lead-form',
    ]];
}
