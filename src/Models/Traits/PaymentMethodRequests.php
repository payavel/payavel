<?php

namespace Payavel\Models\Traits;

trait PaymentMethodRequests
{
    use ConfiguresPaymentGateway;

    /**
     * Fetch the payment method details from the provider.
     *
     * @return \Payavel\PaymentResponse
     */
    public function fetch()
    {
        return $this->gateway->getPaymentMethod($this);
    }

    /**
     * Request the provider to update the payment method's details.
     *
     * @param array|mixed $data
     * @return \Payavel\PaymentResponse
     */
    public function patch($data)
    {
        return $this->gateway->updatePaymentMethod($this, $data);
    }

    /**
     * Request the provider to remove the payment method from their system.
     *
     * @return \Payavel\PaymentResponse
     */
    public function disable()
    {
        return $this->gateway->deletePaymentMethod($this);
    }
}
