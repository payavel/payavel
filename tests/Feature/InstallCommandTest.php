<?php

namespace Payavel\Tests;

use Payavel\Models\PaymentMerchant;
use Payavel\Models\PaymentProvider;

class InstallCommandTest extends TestCase
{    
    /** @test */
    public function install_command_publishes_migration_and_generates_config_with_single_provider_and_merchant()
    {
        $provider = PaymentProvider::factory()->make();
        $merchant = PaymentMerchant::factory()->make();

        $this->artisan('payavel:install')
            ->expectsOutput('Fake payment gateway generated successfully!')
            ->expectsQuestion('What payment provider would you like to add?', $provider->name)
            ->expectsQuestion('How would you like to identify the ' . $provider->name . ' payment provider?', $provider->id)
            ->expectsOutput($provider->name . ' payment gateway generated successfully!')
            ->expectsConfirmation('Would you like to add another payment provider?', 'no')
            ->expectsQuestion('What payment merchant would you like to add?', $merchant->name)
            ->expectsQuestion('How would you like to identify the ' . $merchant->name . ' payment merchant?', $merchant->id)
            ->expectsConfirmation('Would you like to add another payment merchant?', 'no')
            ->expectsOutput('The payment config has been successfully generated.')
            ->assertExitCode(0);
        
        $this->assertFileExists(config_path('payment.php'));
        $config = require(config_path('payment.php'));

        $this->assertEquals($provider->id, $config['defaults']['provider']);
        $this->assertEquals($merchant->id, $config['defaults']['merchant']);
        $this->assertEquals($provider->name, $config['providers'][$provider->id]['name']);
        $this->assertEquals($merchant->name, $config['merchants'][$merchant->id]['name']);
        $this->assertNotNull($config['merchants'][$merchant->id]['providers'][$provider->id]);

        $this->assertTrue(unlink(config_path('payment.php')));
    }

    /** @test */
    public function install_command_publishes_migration_and_generates_config_with_multiple_providers_and_merchants()
    {
        $provider1 = PaymentProvider::factory()->make();
        $provider2 = PaymentProvider::factory()->make();
        $merchant1 = PaymentMerchant::factory()->make();
        $merchant2 = PaymentMerchant::factory()->make();
        $merchant3 = PaymentMerchant::factory()->make();

        $this->artisan('payavel:install')
            ->expectsOutput('Fake payment gateway generated successfully!')
            ->expectsQuestion('What payment provider would you like to add?', $provider1->name)
            ->expectsQuestion('How would you like to identify the ' . $provider1->name . ' payment provider?', $provider1->id)
            ->expectsOutput($provider1->name . ' payment gateway generated successfully!')
            ->expectsConfirmation('Would you like to add another payment provider?', 'yes')
            ->expectsQuestion('What payment provider would you like to add?', $provider2->name)
            ->expectsQuestion('How would you like to identify the ' . $provider2->name . ' payment provider?', $provider2->id)
            ->expectsOutput($provider2->name . ' payment gateway generated successfully!')
            ->expectsConfirmation('Would you like to add another payment provider?', 'no')
            ->expectsChoice(
                'Which provider will be used as default?',
                $provider1->id,
                [$provider1->id, $provider2->id]
            )
            ->expectsQuestion('What payment merchant would you like to add?', $merchant1->name)
            ->expectsQuestion('How would you like to identify the ' . $merchant1->name . ' payment merchant?', $merchant1->id)
            ->expectsChoice(
                "Which providers will be processing payments for the {$merchant1->name} merchant? (default first)",
                [$provider1->id],
                [$provider1->id, $provider2->id]
            )
            ->expectsConfirmation('Would you like to add another payment merchant?', 'yes')
            ->expectsQuestion('What payment merchant would you like to add?', $merchant2->name)
            ->expectsQuestion('How would you like to identify the ' . $merchant2->name . ' payment merchant?', $merchant2->id)
            ->expectsChoice(
                "Which providers will be processing payments for the {$merchant2->name} merchant? (default first)",
                [$provider2->id],
                [$provider1->id, $provider2->id]
            )
            ->expectsConfirmation('Would you like to add another payment merchant?', 'yes')
            ->expectsQuestion('What payment merchant would you like to add?', $merchant3->name)
            ->expectsQuestion('How would you like to identify the ' . $merchant3->name . ' payment merchant?', $merchant3->id)
            ->expectsChoice(
                "Which providers will be processing payments for the {$merchant3->name} merchant? (default first)",
                [$provider1->id, $provider2->id],
                [$provider1->id, $provider2->id]
            )
            ->expectsConfirmation('Would you like to add another payment merchant?', 'no')
            ->expectsChoice(
                "Which merchant will be used as default?",
                $merchant1->id,
                [$merchant1->id, $merchant2->id, $merchant3->id]
            )
            ->expectsOutput('The payment config has been successfully generated.')
            ->assertExitCode(0);

        $this->assertFileExists(config_path('payment.php'));
        $config = require(config_path('payment.php'));

        $this->assertEquals($provider1->id, $config['defaults']['provider']);
        $this->assertEquals($merchant1->id, $config['defaults']['merchant']);

        $randomProvider = $this->faker->randomElement([$provider1, $provider2]);
        $this->assertNotNull($config['providers'][$randomProvider->id]);
        $this->assertEquals($randomProvider->name, $config['providers'][$randomProvider->id]['name']);

        $randomMerchant = $this->faker->randomElement([$merchant1, $merchant2, $merchant3]);
        $this->assertNotNull($config['merchants'][$randomMerchant->id]);
        $this->assertEquals($randomMerchant->name, $config['merchants'][$randomMerchant->id]['name']);
        $this->assertTrue(count($config['merchants'][$randomMerchant->id]['providers']) > 0);

        $this->assertTrue(unlink(config_path('payment.php')));
    }
}
