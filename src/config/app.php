<?php
return [
  'site_name'       => 'LoanSathi',
  'tagline'         => 'Your trusted loan companion',
  'base_url'        => (function() {
                        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
                        $scheme = (($_SERVER['HTTPS'] ?? '') === 'on') ? 'https' : 'http';
                        return $scheme . '://' . $host;
                      })(),
  'contact' => [
    'phone'         => '+91XXXXXXXXXX',
    'phone_display' => '+91 XXXXX XXXXX',
    'whatsapp'      => '91XXXXXXXXXX',
    'email'         => 'hello@loansathi.in',
    'lead_inbox'    => 'leads@loansathi.in',
  ],
  'smtp' => [
    'host'          => getenv('SMTP_HOST') ?: 'localhost',
    'port'          => (int)(getenv('SMTP_PORT') ?: 587),
    'username'      => getenv('SMTP_USER') ?: '',
    'password'      => getenv('SMTP_PASS') ?: '',
    'secure'        => getenv('SMTP_SECURE') ?: 'tls',
    'from_address'  => getenv('SMTP_FROM') ?: 'no-reply@loansathi.in',
    'from_name'     => 'LoanSathi',
  ],
  'gsc_verification' => '',
  'bing_verification' => '',
  'eligibility' => [
    'gold_rate_per_gram'   => 6000,
    'gold_ltv'             => 0.75,
    'home_max_emi_ratio'   => 0.55,
    'lap_ltv'              => 0.65,
    'vehicle_ltv'          => 0.85,
    'business_multiplier'  => 0.30,
    'edu_no_collateral_cap' => 750000,
    'edu_with_collateral_cap' => 5000000,
  ],
  'loan_types' => [
    'personal'  => 'Personal Loan',
    'home'      => 'Home Loan',
    'business'  => 'Business Loan',
    'gold'      => 'Gold Loan',
    'lap'       => 'Loan Against Property',
    'education' => 'Education Loan',
    'vehicle'   => 'Vehicle Loan',
  ],
];
