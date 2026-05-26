<?php

/**
 * Each eligibility function takes a profile array and returns:
 * ['eligible' => bool, 'amount' => float, 'reason' => ?string]
 */

function eligibility_personal(array $p): array {
    $desired = (float)($p['desired'] ?? 0);
    $income  = (float)($p['monthly_income'] ?? 0);
    $emi     = (float)($p['existing_emi'] ?? 0);
    $age     = (int)($p['age'] ?? 0);
    $score   = $p['credit_score'] ?? '';

    if ($age < 21 || $age > 60) {
        return ['eligible' => false, 'amount' => 0.0, 'reason' => 'Age must be between 21 and 60.'];
    }
    if ($score === 'below_650') {
        return ['eligible' => false, 'amount' => 0.0, 'reason' => 'A credit score below 650 typically disqualifies a personal loan.'];
    }
    $capacity = (24 * $income) - (12 * $emi);
    if ($capacity <= 0) {
        return ['eligible' => false, 'amount' => 0.0, 'reason' => 'Existing EMIs exceed repayment capacity.'];
    }
    $amount = min($desired > 0 ? $desired : $capacity, $capacity);
    return ['eligible' => true, 'amount' => round($amount, 2), 'reason' => null];
}

function eligibility_home(array $p): array {
    $income = (float)($p['monthly_income'] ?? 0);
    $emi    = (float)($p['existing_emi'] ?? 0);
    $rate   = (float)($p['rate'] ?? 8.5);
    $n      = (int)($p['tenure_months'] ?? 240);
    $desired = (float)($p['desired'] ?? 0);

    $ratio = config('eligibility.home_max_emi_ratio');
    $max_emi = ($income * $ratio) - $emi;
    if ($max_emi <= 0) {
        return ['eligible' => false, 'amount' => 0.0, 'reason' => 'No EMI headroom.'];
    }
    $r = $rate / 12 / 100;
    if ($r == 0.0) {
        $principal = $max_emi * $n;
    } else {
        $pow = pow(1 + $r, $n);
        $principal = $max_emi * ($pow - 1) / ($r * $pow);
    }
    $amount = $desired > 0 ? min($principal, $desired) : $principal;
    return ['eligible' => true, 'amount' => round($amount, 2), 'reason' => null];
}

function eligibility_business(array $p): array {
    $turnover = (float)($p['annual_turnover'] ?? 0);
    $desired  = (float)($p['desired'] ?? 0);
    $mult = config('eligibility.business_multiplier');
    if ($turnover <= 0) return ['eligible' => false, 'amount' => 0.0, 'reason' => 'Annual turnover required.'];
    $cap = $turnover * $mult;
    $amount = $desired > 0 ? min($cap, $desired) : $cap;
    return ['eligible' => true, 'amount' => round($amount, 2), 'reason' => null];
}

function eligibility_gold(array $p): array {
    $grams = (float)($p['gold_grams'] ?? 0);
    $desired = (float)($p['desired'] ?? 0);
    $rate = config('eligibility.gold_rate_per_gram');
    $ltv  = config('eligibility.gold_ltv');
    if ($grams <= 0) return ['eligible' => false, 'amount' => 0.0, 'reason' => 'Gold weight required.'];
    $cap = $grams * $rate * $ltv;
    $amount = $desired > 0 ? min($cap, $desired) : $cap;
    return ['eligible' => true, 'amount' => round($amount, 2), 'reason' => null];
}

function eligibility_lap(array $p): array {
    $val = (float)($p['property_value'] ?? 0);
    $desired = (float)($p['desired'] ?? 0);
    $ltv = config('eligibility.lap_ltv');
    if ($val <= 0) return ['eligible' => false, 'amount' => 0.0, 'reason' => 'Property value required.'];
    $cap = $val * $ltv;
    $amount = $desired > 0 ? min($cap, $desired) : $cap;
    return ['eligible' => true, 'amount' => round($amount, 2), 'reason' => null];
}

function eligibility_education(array $p): array {
    $hasCol  = (bool)($p['has_collateral'] ?? false);
    $desired = (float)($p['desired'] ?? 0);
    $cap = $hasCol
        ? config('eligibility.edu_with_collateral_cap')
        : config('eligibility.edu_no_collateral_cap');
    $amount = $desired > 0 ? min($cap, $desired) : $cap;
    return ['eligible' => true, 'amount' => (float)round($amount, 2), 'reason' => null];
}

function eligibility_vehicle(array $p): array {
    $price = (float)($p['on_road_price'] ?? 0);
    $desired = (float)($p['desired'] ?? 0);
    $ltv = config('eligibility.vehicle_ltv');
    if ($price <= 0) return ['eligible' => false, 'amount' => 0.0, 'reason' => 'Vehicle price required.'];
    $cap = $price * $ltv;
    $amount = $desired > 0 ? min($cap, $desired) : $cap;
    return ['eligible' => true, 'amount' => round($amount, 2), 'reason' => null];
}
