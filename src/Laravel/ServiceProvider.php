<?php

namespace CodeDistortion\TillPayments\Laravel;

use CodeDistortion\TillPayments\TillPaymentsApiClient;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use GuzzleHttp\Client as GuzzleClient;

/**
 * RealNum & Percent ServiceProvider for Laravel.
 */
class ServiceProvider extends BaseServiceProvider
{
    public const CONFIG_NAME = 'code_distortion.till_payments';
    public const CONFIG_PATH = __DIR__ . '/config/config.php';



    /**
     * Service-provider register method.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(TillPaymentsApiClient::class, function ($app) {
            return new TillPaymentsApiClient(
                config(static::CONFIG_NAME . '.host', ''),
                config(static::CONFIG_NAME . '.username', ''),
                config(static::CONFIG_NAME . '.password', ''),
                config(static::CONFIG_NAME . '.api_key', ''),
                config(static::CONFIG_NAME . '.shared_secret', ''),
                config(static::CONFIG_NAME . '.add_signature', true),
                config(static::CONFIG_NAME . '.public_integration_key', true),
                new GuzzleClient()
            );
        });
    }

    /**
     * Service-provider boot method.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->initialiseConfig();
        $this->publishesConfig();
    }



    /**
     * Initialise the config file.
     *
     * @return void
     */
    protected function initialiseConfig(): void
    {
        $this->mergeConfigFrom(static::CONFIG_PATH, static::CONFIG_NAME);
    }

    /**
     * Allow the default config to be published.
     *
     * @return void
     */
    protected function publishesConfig(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }
        if ($this->app->runningUnitTests()) {
            return;
        }

        $this->publishes(
            [static::CONFIG_PATH => config_path(static::CONFIG_NAME . '.php')],
            'config'
        );
    }
}
