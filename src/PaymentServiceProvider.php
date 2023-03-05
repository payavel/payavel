<?php

namespace Payavel;

use Illuminate\Support\ServiceProvider;
use Payavel\Console\Commands\AddProvider;
use Payavel\Console\Commands\Install;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->vendorPublish();
            $this->commands([
                AddProvider::class,
                Install::class,
            ]);
        }
    }

    protected function vendorPublish()
    {
        $this->publishes([
            __DIR__ . '/database/migrations/2021_01_01_000000_create_base_payment_tables.php' => database_path('migrations/' . now()->format('Y_m_d_His') . '_create_base_payment_tables.php'),
        ], 'migrations');
    }

    public function register()
    {
        $this->app->singleton(PaymentGateway::class, function ($app) {
            return new PaymentGateway();
        });

        $this->mergeConfigFrom(
            __DIR__ . '/config/payment.php',
            'payment'
        );
    }
}
