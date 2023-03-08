<?php

namespace Payavel\Tests;

use Illuminate\Support\Str;
use Payavel\Models\PaymentProvider;

class MakeProviderCommandTest extends TestCase
{
    /** @test */
    public function make_payment_provider_command_will_prompt_for_missing_arguments()
    {
        $provider = PaymentProvider::factory()->make();

        $this->artisan('payavel:provider')
            ->expectsQuestion('What payment provider would you like to add?', $provider->name)
            ->expectsQuestion("How would you like to identify the {$provider->name} payment provider?", $provider->id)
            ->expectsOutput("{$provider->name} payment gateway generated successfully!")
            ->assertExitCode(0);

        $this->assertGatewayExists($provider->id);
    }

    /** @test */
    public function make_payment_provider_command_completes_without_asking_questions_when_providing_the_arguments()
    {
        $provider = PaymentProvider::factory()->make();

        $this->artisan('payavel:provider', [
                'provider' => $provider->name,
                '--id' => $provider->id,
            ])
            ->expectsOutput("{$provider->name} payment gateway generated successfully!")
            ->assertExitCode(0);

        $this->assertGatewayExists($provider->id);
    }

    /** @test */
    public function make_payment_provider_command_with_fake_argument_generates_fake_gateway()
    {
        $arguments = [
            '--fake' => true,
        ];

        $this->artisan('payavel:provider', $arguments)
            ->expectsOutput('Fake payment gateway generated successfully!')
            ->assertExitCode(0);

        $this->assertGatewayExists('fake');
    }

    private function assertGatewayExists(string $id)
    {
        $provider = Str::studly($id);

        $servicePath = app_path('Services/Payment');

        $this->assertTrue(file_exists("{$servicePath}/{$provider}PaymentRequest.php"));
        $this->assertTrue(file_exists("{$servicePath}/{$provider}PaymentResponse.php"));
    }
}
