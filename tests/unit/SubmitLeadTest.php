<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/lib/helpers.php';
require_once __DIR__ . '/../../src/lib/validator.php';
require_once __DIR__ . '/../../src/handlers/submit_lead_logic.php';

class SubmitLeadTest extends TestCase
{
    public function test_honeypot_drops_silently(): void
    {
        $r = process_lead_submission([
            'name' => 'A B', 'phone' => '9876543210', 'loan_type' => 'personal',
            'website' => 'http://spam.example',
            '_csrf' => 'token', 'session_csrf' => 'token',
        ], '127.0.0.1', 'UA');
        $this->assertTrue($r['ok']);
        $this->assertSame('honeypot', $r['note']);
    }

    public function test_bad_csrf_rejected(): void
    {
        $r = process_lead_submission([
            'name' => 'A B', 'phone' => '9876543210', 'loan_type' => 'personal',
            '_csrf' => 'one', 'session_csrf' => 'two',
        ], '127.0.0.1', 'UA');
        $this->assertFalse($r['ok']);
        $this->assertSame('csrf', $r['code']);
    }

    public function test_validation_errors_returned(): void
    {
        $r = process_lead_submission([
            'name' => '', 'phone' => 'bad', 'loan_type' => 'fake',
            '_csrf' => 'token', 'session_csrf' => 'token',
        ], '127.0.0.1', 'UA');
        $this->assertFalse($r['ok']);
        $this->assertSame('validation', $r['code']);
        $this->assertArrayHasKey('name', $r['errors']);
        $this->assertArrayHasKey('phone', $r['errors']);
        $this->assertArrayHasKey('loan_type', $r['errors']);
    }

    public function test_happy_path_returns_data(): void
    {
        $r = process_lead_submission([
            'name' => 'Aman Kumar', 'phone' => '9876543210', 'email' => 'a@b.in',
            'loan_type' => 'personal', 'loan_amount' => 500000,
            '_csrf' => 'token', 'session_csrf' => 'token',
        ], '127.0.0.1', 'UA');
        $this->assertTrue($r['ok']);
        $this->assertSame('Aman Kumar', $r['data']['name']);
    }
}
