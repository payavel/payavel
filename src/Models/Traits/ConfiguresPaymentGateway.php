<?php

namespace Payavel\Models\Traits;

use Payavel\PaymentGateway;

trait ConfiguresPaymentGateway
{
    /**
     * The payment method's pre-configured gateway.
     *
     * @var \Payavel\PaymentGateway
     */
    private $paymentGateway;

    /**
     * Retrieve the payment method's configured gateway.
     *
     * @return \Payavel\PaymentGateway
     */
    public function getGatewayAttribute()
    {
        if (! isset($this->paymentGateway)) {
            $this->paymentGateway = (new PaymentGateway)
                ->provider($this->provider)
                ->merchant($this->merchant);
        }

        return $this->paymentGateway;
    }
}
