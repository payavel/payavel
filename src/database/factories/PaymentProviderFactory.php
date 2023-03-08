<?php

namespace Payavel\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Payavel\Models\PaymentProvider;

class PaymentProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @return string
     */
    public function modelName()
    {
        return config('payment.models.' . PaymentProvider::class, PaymentProvider::class);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $provider = Str::remove(['\'', ','], $this->faker->unique()->company());
        $id = preg_replace('/[^a-z0-9]+/i', '_', strtolower($provider));
        $studlyProvider = Str::studly($id);

        return [
            'id' => $id,
            'name' => $provider,
            'request_class' => "\App\Services\Payment\{$studlyProvider}PaymentRequest",
            'request_class' => "\App\Services\Payment\{$studlyProvider}PaymentResponse",
        ];
    }
}
