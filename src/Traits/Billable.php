<?php

namespace Payavel\Traits;

use Payavel\Models\Wallet;

trait Billable
{
    /**
     * Get the billable's wallets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function wallets()
    {
        return $this->morphMany(Wallet::class, 'billable');
    }
}
