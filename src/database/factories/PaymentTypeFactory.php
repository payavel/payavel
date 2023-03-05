<?php

namespace Payavel\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Payavel\Models\PaymentType;

class PaymentTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @return string
     */
    public function modelName()
    {
        return config('payment.models.' . PaymentType::class, PaymentType::class);
    }

    public const DEFAULTS = [
        [
            'name' => 'VISA',
            'slug' => 'visa',
        ],
        [
            'name' => 'MasterCard',
            'slug' => 'mastercard',
        ],
        [
            'name' => 'AMEX',
            'slug' => 'amex',
        ],
        [
            'name' => 'Alipay',
            'slug' => 'alipay',
        ],
        [
            'name' => 'Apple Pay',
            'slug' => 'apple_pay',
        ],
        [
            'name' => 'Google Pay',
            'slug' => 'google_pay',
        ],
        [
            'name' => 'JCB',
            'slug' => 'jcb',
        ],
        [
            'name' => 'Diners Club',
            'slug' => 'diners_club',
        ],
        [
            'name' => 'Discover',
            'slug' => 'discover',
        ],
        [
            'name' => 'PayPal',
            'slug' => 'paypal',
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->lexify('????');

        return [
            'name' => ucfirst($name),
            'slug' => PaymentType::slugify($name),
        ];
    }

    public function real()
    {
        return $this->state(function () {
            $type = collect(static::DEFAULTS)->whereNotIn('slug', PaymentType::all()->pluck('slug'))->first();

            if (is_null($type))
            {
                return [];
            }

            return $type;
        });
    }
}
