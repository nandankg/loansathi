<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/lib/calculator.php';

class CalculatorTest extends TestCase
{
    public function test_emi_standard_case(): void
    {
        $emi = calculate_emi(100000, 12, 24);
        $this->assertEqualsWithDelta(4707.35, $emi, 0.05);
    }

    public function test_emi_home_loan_case(): void
    {
        $emi = calculate_emi(5000000, 8.5, 240);
        $this->assertEqualsWithDelta(43391, $emi, 1);
    }

    public function test_emi_zero_rate(): void
    {
        $emi = calculate_emi(120000, 0, 12);
        $this->assertEqualsWithDelta(10000, $emi, 0.01);
    }

    public function test_emi_one_month_tenure(): void
    {
        $emi = calculate_emi(10000, 12, 1);
        $this->assertEqualsWithDelta(10100, $emi, 1);
    }

    public function test_emi_breakdown_totals(): void
    {
        $b = calculate_emi_breakdown(100000, 12, 24);
        $this->assertArrayHasKey('emi', $b);
        $this->assertArrayHasKey('total_interest', $b);
        $this->assertArrayHasKey('total_payment', $b);
        $this->assertEqualsWithDelta($b['total_payment'], $b['emi'] * 24, 0.5);
    }
}
