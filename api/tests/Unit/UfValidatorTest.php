<?php

namespace Tests\Unit;

use App\Validators\UfValidator;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\TestCase;

class UfValidatorTest extends TestCase
{
    public function test_valid_uf()
    {
        $this->expectNotToPerformAssertions();
        UfValidator::validate('SP');
    }

    public function test_invalid_uf()
    {
        $this->expectException(ValidationException::class);
        UfValidator::validate('SaoPaulo');
    }
}