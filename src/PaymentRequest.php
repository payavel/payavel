<?php

namespace Payavel;

use Payavel\Contracts\Merchantable;
use Payavel\Contracts\PaymentRequestor;
use Payavel\Contracts\Providable;
use Payavel\Traits\PaymentRequests;

abstract class PaymentRequest implements PaymentRequestor
{
    use PaymentRequests;

    /**
     * The payment provider.
     *
     * @var \Payavel\Contracts\Providable
     */
    protected $provider;

    /**
     * The payment merchant.
     *
     * @var \Payavel\Contracts\Merchantable
     */
    protected $merchant;

    /**
     * @param  \Payavel\Contracts\Providable $provider
     * @param  \Payavel\Contracts\Merchantable $merchant
     */
    public function __construct(Providable $provider, Merchantable $merchant)
    {
        $this->provider = $provider;
        $this->merchant = $merchant;

        $this->setUp();
    }

    /**
     * Set up the request.
     *
     * @return void
     */
    protected function setUp()
    {
        //
    }
}
