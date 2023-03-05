<?php

namespace Payavel\Contracts;

interface Billable
{
    /**
     * Get the billable's wallets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function wallets();
}
