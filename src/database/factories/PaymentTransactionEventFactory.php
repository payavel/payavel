<?php

namespace Payavel\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Models\PaymentTransaction;
use Payavel\Models\PaymentTransactionEvent;
use Payavel\PaymentStatus;

class PaymentTransactionEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @return string
     */
    public function modelName()
    {
        return config('payment.models.' . PaymentTransactionEvent::class, PaymentTransactionEvent::class);
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
            'status_code' => $this->faker->randomElement([
                PaymentStatus::CAPTURED,
                PaymentStatus::SETTLED,
                PaymentStatus::VOIDED,
                PaymentStatus::REFUNDED,
                PaymentStatus::REFUND_SETTLED,
            ]),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (PaymentTransactionEvent $transactionEvent) {
            if (is_null($transactionEvent->transaction_id)) {
                $transaction = PaymentTransaction::factory()->create();

                $transactionEvent->transaction_id = $transaction->id;
            }

            if (is_null($transactionEvent->amount)) {
                $transactionEvent->amount = $transactionEvent->transaction->amount;
            }
        });
    }
}
