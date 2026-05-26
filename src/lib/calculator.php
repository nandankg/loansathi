<?php

/**
 * Standard EMI formula:
 * EMI = P * r * (1+r)^n / ((1+r)^n - 1)
 * where r = annual_rate / 12 / 100, n = tenure_months.
 *
 * Zero-rate special case: EMI = P / n.
 */
function calculate_emi(float $principal, float $annual_rate, int $tenure_months): float {
    if ($principal <= 0 || $tenure_months <= 0) return 0.0;
    if ($annual_rate == 0.0) return round($principal / $tenure_months, 2);

    $r = $annual_rate / 12 / 100;
    $pow = pow(1 + $r, $tenure_months);
    return round(($principal * $r * $pow) / ($pow - 1), 2);
}

function calculate_emi_breakdown(float $principal, float $annual_rate, int $tenure_months): array {
    $emi = calculate_emi($principal, $annual_rate, $tenure_months);
    $total_payment = round($emi * $tenure_months, 2);
    $total_interest = round($total_payment - $principal, 2);
    return [
        'emi'            => $emi,
        'principal'      => $principal,
        'total_interest' => $total_interest,
        'total_payment'  => $total_payment,
        'tenure_months'  => $tenure_months,
        'annual_rate'    => $annual_rate,
    ];
}

function amortization_schedule(float $principal, float $annual_rate, int $tenure_months): array {
    $emi = calculate_emi($principal, $annual_rate, $tenure_months);
    $r = $annual_rate / 12 / 100;
    $balance = $principal;
    $rows = [];
    for ($m = 1; $m <= $tenure_months; $m++) {
        $interest = round($balance * $r, 2);
        $princ_part = round($emi - $interest, 2);
        $balance = round($balance - $princ_part, 2);
        if ($m === $tenure_months) {
            $princ_part = round($princ_part + $balance, 2);
            $balance = 0.0;
        }
        $rows[] = [
            'month'     => $m,
            'emi'       => $emi,
            'interest'  => $interest,
            'principal' => $princ_part,
            'balance'   => $balance,
        ];
    }
    return $rows;
}
