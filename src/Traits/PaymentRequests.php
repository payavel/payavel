<?php

namespace Payavel\Traits;

use Payavel\Contracts\Billable;
use Payavel\Models\PaymentMethod;
use Payavel\Models\PaymentTransaction;
use Payavel\Models\Wallet;

trait PaymentRequests
{
    use ThrowsRuntimeException;

    /**
     * Retrieve the wallet's details from the provider.
     *
     * @param \Payavel\Models\Wallet $wallet
     * @return \Payavel\PaymentResponse
     */
    public function getWallet(Wallet $wallet)
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Retrieve the payment method's details from the provider.
     * 
     * @param \Payavel\Models\PaymentMethod $paymentMethod
     * @return \Payavel\PaymentResponse
     */
    public function getPaymentMethod(PaymentMethod $paymentMethod)
    {
        $this->throwRuntimeException(__FUNCTION__);
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
        $this->throwRuntimeException(__FUNCTION__);
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
        $this->throwRuntimeException(__FUNCTION__);
    }
    
    /**
     * Delete the payment method at the provider.
     * 
     * @param \Payavel\Models\PaymentMethod $paymentMethod
     * @return \Payavel\PaymentResponse
     */
    public function deletePaymentMethod(PaymentMethod $paymentMethod)
    {
        $this->throwRuntimeException(__FUNCTION__);
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
        $this->throwRuntimeException(__FUNCTION__);
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
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Void a previously authorized transaction.
     * 
     * @param \Payavel\Models\PaymentTransaction $paymentTransaction
     * @param array|mixed $data
     * @return \Payavel\PaymentResponse
     */
    public function void(PaymentTransaction $paymentTransaction, $data = [])
    {
        $this->throwRuntimeException(__FUNCTION__);
    }

    /**
     * Refund a previously captured transaction.
     * 
     * @param \Payavel\Models\PaymentTransaction $paymentTransaction
     * @param array|mixed $data
     * @return \Payavel\PaymentResponse
     */
    public function refund(PaymentTransaction $paymentTransaction, $data = [])
    {
        $this->throwRuntimeException(__FUNCTION__);
    }
}
