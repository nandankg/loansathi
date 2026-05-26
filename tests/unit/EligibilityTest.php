<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/lib/helpers.php';
require_once __DIR__ . '/../../src/lib/eligibility.php';

class EligibilityTest extends TestCase
{
    public function test_personal_loan_high_income(): void
    {
        $r = eligibility_personal(['desired' => 500000, 'monthly_income' => 100000, 'existing_emi' => 10000, 'age' => 35, 'credit_score' => 'good']);
        $this->assertTrue($r['eligible']);
        $this->assertSame(500000.0, $r['amount']);
    }

    public function test_personal_loan_low_score_ineligible(): void
    {
        $r = eligibility_personal(['desired' => 100000, 'monthly_income' => 50000, 'existing_emi' => 0, 'age' => 30, 'credit_score' => 'below_650']);
        $this->assertFalse($r['eligible']);
    }

    public function test_personal_loan_age_out_of_range(): void
    {
        $r = eligibility_personal(['desired' => 100000, 'monthly_income' => 100000, 'existing_emi' => 0, 'age' => 65, 'credit_score' => 'excellent']);
        $this->assertFalse($r['eligible']);
    }

    public function test_personal_loan_capped_by_capacity(): void
    {
        $r = eligibility_personal(['desired' => 2000000, 'monthly_income' => 30000, 'existing_emi' => 0, 'age' => 30, 'credit_score' => 'good']);
        $this->assertTrue($r['eligible']);
        $this->assertSame(720000.0, $r['amount']);
    }

    public function test_home_loan_eligibility(): void
    {
        $r = eligibility_home(['desired' => 5000000, 'monthly_income' => 80000, 'existing_emi' => 0, 'rate' => 8.5, 'tenure_months' => 240]);
        $this->assertTrue($r['eligible']);
        $this->assertGreaterThan(4000000, $r['amount']);
    }

    public function test_business_loan_eligibility(): void
    {
        $r = eligibility_business(['desired' => 5000000, 'annual_turnover' => 10000000]);
        $this->assertTrue($r['eligible']);
        $this->assertSame(3000000.0, $r['amount']);
    }

    public function test_gold_loan_eligibility(): void
    {
        $r = eligibility_gold(['desired' => 600000, 'gold_grams' => 100]);
        $this->assertTrue($r['eligible']);
        $this->assertSame(450000.0, $r['amount']);
    }

    public function test_lap_eligibility(): void
    {
        $r = eligibility_lap(['desired' => 8000000, 'property_value' => 10000000]);
        $this->assertTrue($r['eligible']);
        $this->assertSame(6500000.0, $r['amount']);
    }

    public function test_education_loan_no_collateral_cap(): void
    {
        $r = eligibility_education(['desired' => 2000000, 'has_collateral' => false]);
        $this->assertTrue($r['eligible']);
        $this->assertSame(750000.0, $r['amount']);
    }

    public function test_education_loan_with_collateral_higher_cap(): void
    {
        $r = eligibility_education(['desired' => 3000000, 'has_collateral' => true]);
        $this->assertTrue($r['eligible']);
        $this->assertSame(3000000.0, $r['amount']);
    }

    public function test_vehicle_loan_eligibility(): void
    {
        $r = eligibility_vehicle(['desired' => 700000, 'on_road_price' => 800000]);
        $this->assertTrue($r['eligible']);
        $this->assertSame(680000.0, $r['amount']);
    }
}
