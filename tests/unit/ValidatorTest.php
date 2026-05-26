<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/lib/validator.php';

class ValidatorTest extends TestCase
{
    public function test_valid_indian_phone_10_digits(): void
    {
        $this->assertTrue(is_valid_phone('9876543210'));
    }

    public function test_valid_indian_phone_with_country_code(): void
    {
        $this->assertTrue(is_valid_phone('+919876543210'));
        $this->assertTrue(is_valid_phone('919876543210'));
    }

    public function test_invalid_phone_too_short(): void
    {
        $this->assertFalse(is_valid_phone('12345'));
    }

    public function test_invalid_phone_letters(): void
    {
        $this->assertFalse(is_valid_phone('abc1234567'));
    }

    public function test_valid_email(): void
    {
        $this->assertTrue(is_valid_email('foo@example.in'));
    }

    public function test_invalid_email(): void
    {
        $this->assertFalse(is_valid_email('not-an-email'));
    }

    public function test_empty_email_is_invalid(): void
    {
        $this->assertFalse(is_valid_email(''));
    }

    public function test_valid_name(): void
    {
        $this->assertTrue(is_valid_name('Aman Kumar'));
        $this->assertTrue(is_valid_name("D'Souza"));
    }

    public function test_invalid_name_too_short(): void
    {
        $this->assertFalse(is_valid_name('A'));
    }

    public function test_invalid_name_numbers_only(): void
    {
        $this->assertFalse(is_valid_name('1234'));
    }

    public function test_validate_lead_payload_happy_path(): void
    {
        $data = [
            'name'      => 'Aman Kumar',
            'phone'     => '9876543210',
            'email'     => 'aman@example.in',
            'loan_type' => 'personal',
            'loan_amount' => 500000,
        ];
        $r = validate_lead($data);
        $this->assertTrue($r['ok']);
        $this->assertSame('Aman Kumar', $r['data']['name']);
    }

    public function test_validate_lead_payload_missing_required(): void
    {
        $r = validate_lead(['name' => '', 'phone' => '', 'loan_type' => '']);
        $this->assertFalse($r['ok']);
        $this->assertArrayHasKey('name', $r['errors']);
        $this->assertArrayHasKey('phone', $r['errors']);
        $this->assertArrayHasKey('loan_type', $r['errors']);
    }

    public function test_validate_lead_payload_rejects_bad_loan_type(): void
    {
        $r = validate_lead([
            'name' => 'X X', 'phone' => '9876543210', 'loan_type' => 'mortgage_garbage',
        ]);
        $this->assertFalse($r['ok']);
        $this->assertArrayHasKey('loan_type', $r['errors']);
    }
}
