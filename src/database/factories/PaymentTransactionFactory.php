<?php

namespace Payavel\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Models\PaymentMerchant;
use Payavel\Models\PaymentProvider;
use Payavel\Models\PaymentTransaction;
use Payavel\PaymentStatus;

class PaymentTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @return string
     */
    public function modelName()
    {
        return config('payment.models.' . PaymentTransaction::class, PaymentTransaction::class);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reference' => $this->faker->uuid(),
            'amount' => $this->faker->numberBetween(1, 999) * 100,
            'currency' => $this->faker->currencyCode(),
            'status_code' => PaymentStatus::AUTHORIZED,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (PaymentTransaction $transaction) {
            if (is_null($transaction->provider_id)) {
                $provider = ! is_null($transaction->payment_method_id)
                    ? $transaction->paymentMethod->provider
                    : PaymentProvider::whereHas('merchants', function ($query) use ($transaction) {
                        $query->where('payment_merchants.id', $transaction->merchant_id);
                    })->inRandomOrder()->firstOr(function ()  {
                        return PaymentProvider::factory()->create();
                    });

                $transaction->provider_id = $provider->id;
            }

            if (is_null($transaction->merchant_id)) {
                $merchant = ! is_null($transaction->payment_method_id)
                    ? $transaction->paymentMethod->merchant
                    : PaymentMerchant::whereHas('providers', function ($query) use ($transaction) {
                        $query->where('payment_providers.id', $transaction->provider_id);
                    })->inRandomOrder()->firstOr(function () use ($transaction) {
                        $merchant = PaymentMerchant::factory()->create();

                        $merchant->providers()->attach($transaction->provider_id, ['is_default' => true]);

                        return $merchant;
                    });

                $transaction->merchant_id = $merchant->id;
            }
        });
    }
}
