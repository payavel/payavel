<?php

namespace Payavel\Facades;

use Illuminate\Support\Facades\Facade;
use Payavel\PaymentGateway;

/**
 * @method static \Payavel\PaymentGateway provider($provider)
 * @method static \Payavel\Models\PaymentProvider getProvider()
 * @method static void setProvider($provider)
 * @method static string|int|\Payavel\Models\PaymentProvider getDefaultProvider()
 * @method static \Payavel\PaymentGateway merchant($merchant)
 * @method static \Payavel\Models\PaymentMerchant getMerchant()
 * @method static void setMerchant($merchant, $strict = true)
 * @method static string|int getDefaultMerchant()
 * @method static \Payavel\PaymentResponse getWallet(\Payavel\Models\Wallet $wallet)
 * @method static \Payavel\PaymentResponse getPaymentMethod(\Payavel\Models\PaymentMethod $paymentMethod)
 * @method static \Payavel\PaymentResponse tokenizePaymentMethod(\Payavel\Contracts\Billable $billable, $data)
 * @method static \Payavel\PaymentResponse updatePaymentMethod(\Payavel\Models\PaymentMethod $paymentMethod, $data)
 * @method static \Payavel\PaymentResponse deletePaymentMethod(\Payavel\Models\PaymentMethod $paymentMethod)
 * @method static \Payavel\PaymentResponse authorize($data, \Payavel\Contracts\Billable $billable = null)
 * @method static \Payavel\PaymentResponse capture(\Payavel\Models\PaymentTransaction $transaction, $data = [])
 * @method static \Payavel\PaymentResponse void(\Payavel\Models\PaymentTransaction $transaction, $data = [])
 * @method static \Payavel\PaymentResponse refund(\Payavel\Models\PaymentTransaction $transaction, $data = [])
 * 
 * @see \Payavel\PaymentGateway
 */
class Payment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PaymentGateway::class;
    }
}
