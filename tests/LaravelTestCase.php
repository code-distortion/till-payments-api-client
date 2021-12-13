<?php

namespace CodeDistortion\TillPayments\Tests;

use CodeDistortion\TillPayments\Laravel\ServiceProvider;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;

/**
 * The test case that Laravel tests extend from.
 */
class LaravelTestCase extends TestCase
{
    /**
     * Get package providers.
     *
     * @param Application $app The Laravel app.
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class
        ];
    }
}
