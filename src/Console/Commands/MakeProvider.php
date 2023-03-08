<?php

namespace Payavel\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Payavel\Traits\GeneratesFiles;
use Payavel\Traits\Questionable;

class MakeProvider extends Command
{
    use Questionable, GeneratesFiles;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payavel:provider
                            {provider? : The payment provider name}
                            {--id= : The payment provider identifier}
                            {--fake : Generates a gateway to be used for testing purposes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold a new payment provider\'s gateway and response classes.';

    /**
     * The payment provider attributes to be saved.
     *
     * @var string $name
     * @var string $id
     */
    protected $name, $id;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->setProperties();

        $this->generateProvider();
    }

    /**
     * Format the payment provider's properties.
     *
     * @return void
     */
    protected function setProperties()
    {
        if ($this->option('fake', false)) {
            $this->name = 'Fake';
            $this->id = 'fake';

            return;
        }

        $this->name = trim($this->argument('provider') ?? $this->askName('provider'));

        $this->id = $this->option('id') ?? $this->askId('provider', $this->name);
    }

    /**
     * Generated the provider gateway files.
     *
     * @return void
     */
    protected function generateProvider()
    {
        $provider = Str::studly($this->id);

        $this->putFile(
            app_path("Services/Payment/{$provider}PaymentRequest.php"),
            $this->makeFile(__DIR__ . '/../../stubs/payment-request.stub', ['name' => $provider])
        );

        $this->putFile(
            app_path("Services/Payment/{$provider}PaymentResponse.php"),
            $this->makeFile(__DIR__ . '/../../stubs/payment-response.stub', ['name' => $provider])
        );

        $this->info("{$this->name} payment gateway generated successfully!");
    }
}
