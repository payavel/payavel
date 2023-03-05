<?php

namespace Payavel\Tests\Unit;

use Payavel\Facades\Payment;
use Payavel\Models\PaymentMethod;
use Payavel\Models\PaymentTransaction;
use Payavel\Models\Wallet;
use Payavel\PaymentResponse;
use Payavel\Tests\GatewayTestCase;
use Payavel\Tests\User;

class TestPaymentGateway extends GatewayTestCase
{
    /** @test */
    public function get_wallet_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $response = Payment::getWallet($wallet);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('getWallet', $response->data['requestMethod']);
    }

    /** @test */
    public function get_payment_method_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $paymentMethod = PaymentMethod::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = Payment::getPaymentMethod($paymentMethod);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('getPaymentMethod', $response->data['requestMethod']);
    }

    /** @test */
    public function tokenize_payment_method_method_returns_configured_response()
    {
        $user = User::factory()->create();

        $response = Payment::tokenizePaymentMethod($user, []);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('tokenizePaymentMethod', $response->data['requestMethod']);
    }

    /** @test */
    public function update_payment_method_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $paymentMethod = PaymentMethod::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = Payment::updatePaymentMethod($paymentMethod, []);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('updatePaymentMethod', $response->data['requestMethod']);
    }

    /** @test */
    public function delete_payment_method_method_returns_configured_response()
    {
        $wallet = Wallet::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $paymentMethod = PaymentMethod::factory()->create([
            'wallet_id' => $wallet->id,
        ]);

        $response = Payment::deletePaymentMethod($paymentMethod);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('deletePaymentMethod', $response->data['requestMethod']);
    }

    /** @test */
    public function authorize_method_returns_configured_response()
    {
        $response = Payment::authorize([]);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('authorize', $response->data['requestMethod']);
    }

    /** @test */
    public function capture_method_returns_configured_response()
    {
        $transaction = PaymentTransaction::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $response = Payment::capture($transaction);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('capture', $response->data['requestMethod']);
    }

    /** @test */
    public function void_method_returns_configured_response()
    {
        $transaction = PaymentTransaction::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $response = Payment::void($transaction);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('void', $response->data['requestMethod']);
    }

    /** @test */
    public function refund_method_returns_configured_response()
    {
        $transaction = PaymentTransaction::factory()->create([
            'provider_id' => Payment::getProvider()->getId(),
            'merchant_id' => Payment::getMerchant()->getId(),
        ]);

        $response = Payment::refund($transaction);

        $this->assertResponseIsConfigured($response);

        $this->assertEquals('refund', $response->data['requestMethod']);
    }

    /**
     * Assert the response is configured automatically.
     *
     * @param string $requestMethod
     * @param \Payavel\PaymentResponse $response
     * @return void
     */
    protected function assertResponseIsConfigured(PaymentResponse $response)
    {
        $this->assertEquals(Payment::getProvider()->getId(), $response->provider->id);
        $this->assertEquals(Payment::getMerchant()->getId(), $response->merchant->id);
    }
}
