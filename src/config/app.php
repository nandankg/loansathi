<?php
$env = function(string $key, $default = null) {
    $v = getenv($key);
    if ($v === false || $v === '') return $default;
    return $v;
};
return [
  'site_name'       => 'LoanSathi',
  'tagline'         => 'Your trusted loan companion',
  'base_url'        => $env('BASE_URL') ?: (function() {
                        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
                        $https = (($_SERVER['HTTPS'] ?? '') === 'on')
                              || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
                              || (($_SERVER['HTTP_X_FORWARDED_SSL'] ?? '') === 'on');
                        $scheme = $https ? 'https' : 'http';
                        return $scheme . '://' . $host;
                      })(),
  'contact' => [
    'phone'         => $env('CONTACT_PHONE',         '+91XXXXXXXXXX'),
    'phone_display' => $env('CONTACT_PHONE_DISPLAY', '+91 XXXXX XXXXX'),
    'whatsapp'      => $env('CONTACT_WHATSAPP',      '91XXXXXXXXXX'),
    'email'         => $env('CONTACT_EMAIL',         'hello@loansathi.in'),
    'lead_inbox'    => $env('CONTACT_LEAD_INBOX',    'leads@loansathi.in'),
  ],
  // Legal/identity details shown on the privacy, terms, about, and contact
  // pages. Defaults intentionally read "FILL-IN: ..." so an unset value is
  // obvious on the live site — set the LEGAL_* vars in .env to replace them.
  'legal' => [
    'entity'            => $env('LEGAL_ENTITY',            'FILL-IN: Registered Legal Entity Name'),
    'address'           => $env('LEGAL_ADDRESS',           'FILL-IN: Full Registered Address, City, State, PIN'),
    'grievance_officer' => $env('LEGAL_GRIEVANCE_OFFICER', 'FILL-IN: Grievance Officer Name'),
    'jurisdiction'      => $env('LEGAL_JURISDICTION',      'FILL-IN: City, State'),
  ],
  'smtp' => [
    'host'          => $env('SMTP_HOST',   'localhost'),
    'port'          => (int)$env('SMTP_PORT', 587),
    'username'      => $env('SMTP_USER',   ''),
    'password'      => $env('SMTP_PASS',   ''),
    'secure'        => $env('SMTP_SECURE', 'tls'),
    'from_address'  => $env('SMTP_FROM',   'no-reply@loansathi.in'),
    'from_name'     => 'LoanSathi',
  ],
  'gsc_verification'  => $env('GSC_VERIFICATION',  ''),
  'bing_verification' => $env('BING_VERIFICATION', ''),
  'setup_key'         => $env('SETUP_KEY',         ''),
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
