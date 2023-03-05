<?php

namespace Payavel;

use BadMethodCallException;
use Payavel\Contracts\Billable;
use Payavel\Contracts\PaymentRequestor;
use Payavel\Models\PaymentMethod;
use Payavel\Models\PaymentTransaction;
use Payavel\Models\Wallet;

class PaymentGateway extends PaymentService implements PaymentRequestor
{
    /**
     * Retrieve the wallet's details from the provider.
     *
     * @param \Payavel\Models\Wallet $wallet
     * @return \Payavel\PaymentResponse
     */
    public function getWallet(Wallet $wallet)
    {
        return tap($this->gateway->getWallet($wallet))->configure(__FUNCTION__, $this->provider, $this->merchant);
    }

    /**
     * Retrieve the payment method's details from the provider.
     * 
     * @param \Payavel\Models\PaymentMethod $paymentMethod
     * @return \Payavel\PaymentResponse
     */
    public function getPaymentMethod(PaymentMethod $paymentMethod)
    {
        return tap($this->gateway->getPaymentMethod($paymentMethod))->configure(__FUNCTION__, $this->provider, $this->merchant);
    }

    /**
     * Store the payment method details at the provider.
     * 
     * @param \Payavel\Contracts\Billable $billable
     * @param array|mixed $data
     * @return \Payavel\PaymentResponse
     */
    public function tokenizePaymentMethod(Billable $billable, $data)
    {
        return tap($this->gateway->tokenizePaymentMethod($billable, $data))->configure(__FUNCTION__, $this->provider, $this->merchant);
    }

    /**
     * Update the payment method's details at the provider.
     * 
     * @param \Payavel\Models\PaymentMethod $paymentMethod
     * @param array|mixed $data
     * @return \Payavel\PaymentResponse
     */
    public function updatePaymentMethod(PaymentMethod $paymentMethod, $data)
    {
        return tap($this->gateway->updatePaymentMethod($paymentMethod, $data))->configure(__FUNCTION__, $this->provider, $this->merchant);
    }
    
    /**
     * Delete the payment method at the provider.
     * 
     * @param \Payavel\Models\PaymentMethod $paymentMethod
     * @return \Payavel\PaymentResponse
     */
    public function deletePaymentMethod(PaymentMethod $paymentMethod)
    {
        return tap($this->gateway->deletePaymentMethod($paymentMethod))->configure(__FUNCTION__, $this->provider, $this->merchant);
    }

    /**
     * Authorize a transaction.
     * 
     * @param array|mixed $data
     * @param \Payavel\Contracts\Billable|null $billable
     * @return \Payavel\PaymentResponse
     */
    public function authorize($data, Billable $billable = null)
    {
        return tap($this->gateway->authorize($data, $billable))->configure(__FUNCTION__, $this->provider, $this->merchant);
    }

    /**
     * Capture a previously authorized transaction.
     * 
     * @param \Payavel\Models\PaymentTransaction $transaction
     * @param array|mixed $data
     * @return \Payavel\PaymentResponse
     */
    public function capture(PaymentTransaction $transaction, $data = [])
    {
        return tap($this->gateway->capture($transaction, $data))->configure(__FUNCTION__, $this->provider, $this->merchant);
    }

    /**
     * Void a previously authorized transaction.
     * 
     * @param \Payavel\Models\PaymentTransaction $transaction
     * @param array|mixed $data
     * @return \Payavel\PaymentResponse
     */
    public function void(PaymentTransaction $transaction, $data = [])
    {
        return tap($this->gateway->void($transaction, $data))->configure(__FUNCTION__, $this->provider, $this->merchant);
    }

    /**
     * Refund a previously captured transaction.
     * 
     * @param \Payavel\Models\PaymentTransaction $transaction
     * @param array|mixed $data
     * @return \Payavel\PaymentResponse
     */
    public function refund(PaymentTransaction $transaction, $data = [])
    {
        return tap($this->gateway->refund($transaction, $data))->configure(__FUNCTION__, $this->provider, $this->merchant);
    }

    /**
     * @param string $method
     * @param array $params
     * 
     * @throws \BadMethodCallException
     */
    public function __call($method, $params)
    {
        if (! method_exists($this->gateway, $method)) {
            throw new BadMethodCallException(__CLASS__ . "::{$method}() not found.");
        }

        return tap($this->gateway->{$method}(...$params))->configure($method, $this->provider, $this->merchant);
    }
}
