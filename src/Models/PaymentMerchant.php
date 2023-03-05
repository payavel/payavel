<?php

namespace Payavel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Payavel\Contracts\Merchantable;
use Payavel\Database\Factories\PaymentMerchantFactory;

class PaymentMerchant extends Model implements Merchantable
{
    use HasFactory;

     /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PaymentMerchantFactory::new();
    }

    /**
     * Get the merchant's id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the merchant's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the providers that the merchant belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function providers()
    {
        return $this->belongsToMany(config('payment.models.' . PaymentProvider::class, PaymentProvider::class), 'payment_merchant_provider', 'merchant_id', 'provider_id')->withPivot(['is_default'])->withTimestamps();
    }

    /**
     * Get the merchant's wallets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wallets()
    {
        return $this->hasMany(config('payment.models.' . Wallet::class, Wallet::class), 'merchant_id');
    }

    /**
     * Get the payment methods stored under the merchant's account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function payment_methods()
    {
        return $this->hasManyThrough(config('payment.models.' . PaymentMethod::class, PaymentMethod::class), config('payment.models.' . Wallet::class, Wallet::class), 'merchant_id');
    }
}
