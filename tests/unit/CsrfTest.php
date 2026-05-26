<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/lib/csrf.php';

class CsrfTest extends TestCase
{
    protected function setUp(): void
    {
        $_SESSION = [];
    }

    public function test_token_is_generated_once_per_session(): void
    {
        $t1 = csrf_token();
        $t2 = csrf_token();
        $this->assertSame($t1, $t2);
        $this->assertSame(64, strlen($t1));
    }

    public function test_validate_accepts_matching_token(): void
    {
        $t = csrf_token();
        $this->assertTrue(csrf_validate($t));
    }

    public function test_validate_rejects_wrong_token(): void
    {
        csrf_token();
        $this->assertFalse(csrf_validate('deadbeef'));
    }

    public function test_validate_rejects_missing_token(): void
    {
        $this->assertFalse(csrf_validate(''));
    }
}
