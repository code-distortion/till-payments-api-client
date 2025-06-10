<?php

namespace CodeDistortion\TillPayments\Tests\Unit;

use CodeDistortion\TillPayments\Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * Test the TillPaymentsApiClient class.
 *
 * @group skip
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
#[Group('skip')]
class TillPaymentsApiClientUnitTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    #[Test]
    public function test_something(): void
    {
        self::markTestSkipped();

        return;
    }
}
