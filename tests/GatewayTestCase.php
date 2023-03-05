<?php

namespace Payavel\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Payavel\Contracts\Billable;
use Payavel\Models\PaymentMerchant;
use Payavel\Models\PaymentMethod;
use Payavel\Models\PaymentProvider;
use Payavel\Models\PaymentTransaction;
use Payavel\Models\Wallet;
use Payavel\PaymentRequest;
use Payavel\PaymentResponse;
use Payavel\PaymentStatus;
use Payavel\Traits\Billable as BillableTrait;

abstract class GatewayTestCase extends TestCase
{
    protected $driver;
    protected $provider = 'test';
    protected $merchant = 'tester';

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->{"{$this->driver}DriverSetUp"}();

        Schema::create('users', function ($table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('payment.defaults', [
            'driver' => $this->driver,
            'provider' => $this->provider,
            'merchant' => $this->merchant,
        ]);
    }

    protected function configDriverSetUp()
    {
        config([
            'payment.providers' => [
                $this->provider => [
                    'name' => Str::headline($this->provider),
                    'request_class' => FakePaymentGateway::class,
                    'response_class' => FakePaymentResponse::class,
                ],
            ],
            'payment.merchants' => [
                $this->merchant => [
                    'name' => Str::headline($this->merchant),
                    'providers' => [
                        $this->provider => [
                            'is_default' => true,
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function databaseDriverSetUp()
    {
        $provider = PaymentProvider::create([
            'id' => 'test',
            'name' => 'Test',
            'request_class' => FakePaymentGateway::class,
            'response_class' => FakePaymentResponse::class,
        ]);

        $merchant = PaymentMerchant::create([
            'id' => 'tester',
            'name' => 'Tester',
        ]);

        $merchant->providers()->attach($provider->id, ['is_default' => true]);
    }
}

class FakePaymentGateway extends PaymentRequest
{
    public function getWallet(Wallet $wallet)
    {
        return new FakePaymentResponse([]);
    }

    public function getPaymentMethod(PaymentMethod $paymentMethod)
    {
        return new FakePaymentResponse([]);
    }

    public function tokenizePaymentMethod(Billable $billable, $data)
    {
        return new FakePaymentResponse([]);
    }

    public function updatePaymentMethod(PaymentMethod $paymentMethod, $data)
    {
        return new FakePaymentResponse([]);
    }

    public function deletePaymentMethod(PaymentMethod $paymentMethod)
    {
        return new FakePaymentResponse([]);
    }

    public function authorize($data, Billable $billable = null)
    {
        return new FakePaymentResponse([]);
    }

    public function capture(PaymentTransaction $transaction, $data = [])
    {
        return new FakePaymentResponse([]);
    }

    public function void(PaymentTransaction $paymentTransaction, $data =[])
    {
        return new FakePaymentResponse([]);
    }

    public function refund(PaymentTransaction $paymentTransaction, $data = [])
    {
        return new FakePaymentResponse([]);
    }
}

class FakePaymentResponse extends PaymentResponse
{
    public function getWalletResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function getPaymentMethodResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function tokenizePaymentMethodResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function updatePaymentMethodResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function deletePaymentMethodResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function authorizeResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function captureResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function voidResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function refundResponse()
    {
        return [
            'requestMethod' => $this->requestMethod,
        ];
    }

    public function getStatusCode()
    {
        return PaymentStatus::AUTHORIZED;
    }
}

class User extends Model implements Billable
{
    use BillableTrait,
        HasFactory;

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
        ];
    }
}
