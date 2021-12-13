<?php

namespace CodeDistortion\TillPayments\Tests;

use CodeDistortion\FluentDotEnv\Exceptions\FluentDotEnvException;
use CodeDistortion\FluentDotEnv\FluentDotEnv;
use CodeDistortion\TillPayments\Laravel\ServiceProvider;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\Dusk\TestCase;

/**
 * The test case that Laravel Dusk tests extend from.
 */
class LaravelDuskTestCase extends TestCase
{

    /**
     * Set up the config ready for each test.
     *
     * @return void
     * @throws FluentDotEnvException Thrown by FluentDotEnv when reading from fails.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->loadConfig(ServiceProvider::CONFIG_NAME, ServiceProvider::CONFIG_PATH, __DIR__ . '/../.env');
    }

    /**
     * Load a config file for Laravel to use.
     *
     * @param string      $name        Laravel's name for this config.
     * @param string      $path        The path to the config file.
     * @param string|null $envFilePath The .env file to use.
     * @return void
     * @throws FluentDotEnvException Thrown by FluentDotEnv when reading from fails.
     */
    private function loadConfig(string $name, string $path, string $envFilePath = null): void
    {
        if ($envFilePath) {
            FluentDotEnv::new()->load($envFilePath)->populateEnv(true);
        }
        config([$name => require($path)]);
    }

    /**
     * Get package providers.
     *
     * @param Application $app The Laravel app.
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return RemoteWebDriver
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions())->addArguments([
            '--disable-gpu',
            '--headless',
            '--no-sandbox',
            '--window-size=1920,1080',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()
                ->setCapability(ChromeOptions::CAPABILITY, $options)
                ->setCapability('acceptInsecureCerts', true)
        );
    }
}
