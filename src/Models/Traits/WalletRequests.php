<?php

namespace Payavel\Models\Traits;

trait WalletRequests
{
    use ConfiguresPaymentGateway;

    /**
     * Fetch the wallet details from the provider.
     *
     * @return \Payavel\PaymentResponse
     */
    public function fetch()
    {
        return $this->gateway->getWallet($this);
    }
}
