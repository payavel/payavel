<?php

namespace Payavel\Database\Seeders;

use Illuminate\Database\Seeder;
use Payavel\Database\Factories\PaymentTypeFactory;
use Payavel\Models\PaymentType;

class PaymentTypeSeeder extends Seeder
{
    public function run()
    {
        foreach (PaymentTypeFactory::DEFAULTS as $paymentType) {
            PaymentType::firstOrCreate(
                [
                    'slug' => $paymentType['slug']
                ],
                [
                    'name' => $paymentType['name'],
                ]
            );
        }
    }
}