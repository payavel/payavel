<?php

namespace Payavel;

use Payavel\Contracts\Merchantable;
use Payavel\Contracts\Providable;

abstract class PaymentServiceDriver
{
    /**
     * Resolve the providable instance.
     *
     * @param \Payavel\Contracts\Providable|string|int $provider
     * @return \Payavel\Contracts\Providable|null
     */
    abstract public function resolveProvider($provider);

    /**
     * Get the default providable identifier.
     *
     * @param \Payavel\Contracts\Merchantable|null $merchant
     * @return string|int
     */
    public function getDefaultProvider(Merchantable $merchant = null)
    {
        return config('payment.defaults.provider');
    }

    /**
     * Resolve the merchantable intance.
     *
     * @param \Payavel\Contracts\Merchantable|string|int $merchant
     * @return \Payavel\Contracts\Merchantable|null
     */
    abstract public function resolveMerchant($merchant);

    /**
     * Get the default merchantable identifier.
     *
     * @param \Payavel\Contracts\Providable|null $provider
     * @return string|int
     */
    public function getDefaultMerchant(Providable $provider = null)
    {
        return config('payment.defaults.merchant');
    }

    /**
     * Verify that the merchant is compatible with the provider.
     *
     * @param \Payavel\Contracts\Providable
     * @param \Payavel\Contracts\Merchantable
     * @return bool
     */
    abstract public function check($provider, $merchant);

    /**
     * Resolve the gateway class.
     *
     * @param \Payavel\Contracts\Providable $provider
     * @return string
     */
    abstract public function resolveGatewayClass($provider);
}
