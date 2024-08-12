<?php

namespace CodeDistortion\TillPayments\Tests\Integration;

use CodeDistortion\TillPayments\Tests\LaravelTestCase;
use CodeDistortion\TillPayments\TillPaymentsApiClient;

/**
 * Test integration with Laravel.
 *
 * @group skip
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class LaravelIntegrationTest extends LaravelTestCase
{
    /**
     * Test integration with Laravel.
     *
     * @test
     * @return void
     */
    public function test_laravel_integration(): void
    {
        $client = app(TillPaymentsApiClient::class);
        self::assertInstanceOf(TillPaymentsApiClient::class, $client);
    }
}
