<?php

namespace Payavel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Payavel\Database\Factories\PaymentTransactionFactory;

class PaymentTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'reference',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'details' => 'array',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function newFactory()
    {
        return PaymentTransactionFactory::new();
    }

    /**
     * Get the payment method used for this transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentMethod()
    {
        return $this->belongsTo(config('payment.models.' . PaymentMethod::class, PaymentMethod::class));
    }

    /**
     * Get the provider the transaction belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(config('payment.models.' . PaymentProvider::class, PaymentProvider::class));
    }

    /**
     * Get the merchant the transaction belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchant()
    {
        return $this->belongsTo(config('payment.models.' . PaymentMerchant::class, PaymentMerchant::class));
    }

    /**
     * Get the transaction's event history.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(config('payment.models.' . PaymentTransactionEvent::class, PaymentTransactionEvent::class), 'transaction_id');
    }
}
