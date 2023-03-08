<?php

namespace Payavel\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Payavel\Traits\GeneratesFiles;
use Payavel\Traits\Questionable;

class Install extends Command
{
    use Questionable, GeneratesFiles;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure payments within the application.';

    /**
     * The collected providers.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $providers;

    /**
     * The collected merchants.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $merchants;

    /**
     * The config to be set.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (! class_exists('CreateBasePaymentTables')) {
            $this->call('vendor:publish', ['--provider' => 'Payavel\PaymentServiceProvider', '--tag' => 'migrations']);
        }

        $this->installProviders();

        $this->installMerchants();

        $this->putFile(
            config_path('payment.php'),
            $this->makeFile(
                __DIR__ . '/../../stubs/config-payment.stub',
                [
                    'provider' => $this->config['defaults']['provider'],
                    'providers' => $this->config['providers'],
                    'merchant' => $this->config['defaults']['merchant'],
                    'merchants' => $this->config['merchants'],
                ]
            )
        );

        $this->info('The payment config has been successfully generated.');
    }

    /**
     * Query provider information, generate payment gateways & set the config for chosen providers.
     *
     * @return void
     */
    protected function installProviders()
    {
        $this->call('payment:add-provider', ['--fake' => true]);

        $this->providers = collect([]);

        do {
            $this->providers->push([
                'name' => $name = $this->askName('provider'),
                'id' => $id = $this->askId('provider', $name),
                'provider' => Str::studly($id),
            ]);

            $this->call('payment:add-provider', ['provider' => $name, '--id' => $id]);
        } while ($this->confirm('Would you like to add another payment provider?', false));

        $this->config['providers'] = $this->providers->reduce(function ($config, $provider) {
            return $config . $this->makeFile(__DIR__ . '/../../stubs/config-provider.stub', $provider);
        }, "");

        $this->config['defaults']['provider'] = $this->providers->count() > 1
            ? $this->choice('Which provider will be used as default?', $this->providers->pluck('id')->all())
            : $this->providers->first()['id'];
    }

    /**
     * Query merchant information & set the config for chosen merchants.
     *
     * @return void
     */
    protected function installMerchants()
    {
        $this->merchants = collect([]);

        do {
            $merchant = [
                'name' => $name = $this->askName('merchant'),
                'id' => $this->askId('merchant', $name),
            ];

            $providers = $this->providers->count() > 1
                ? $this->choice(
                    "Which providers will be processing payments for the {$name} merchant? (default first)",
                    $this->providers->pluck('id')->all(),
                    null,
                    null,
                    true
                )
                : [$this->providers->first()['id']];

            $merchant['providers'] = collect($providers)->reduce(function ($config, $provider, $index) use ($providers) {
                return $config . $this->makeFile(__DIR__ . '/../../stubs/config-merchant-providers.stub', ['id' => $provider]) . ($index < count($providers) - 1 ? "\n" : "");
            }, "");

            $this->merchants->push($merchant);
        } while ($this->confirm('Would you like to add another payment merchant?', false));

        $this->config['merchants'] = $this->merchants->reduce(function ($config, $merchant) {
            return $config . $this->makeFile(__DIR__ . '/../../stubs/config-merchant.stub', $merchant);
        }, "");

        $this->config['defaults']['merchant'] = $this->merchants->count() > 1
            ? $this->choice('Which merchant will be used as default?', $this->merchants->pluck('id')->all())
            : $this->merchants->first()['id'];
    }
}
