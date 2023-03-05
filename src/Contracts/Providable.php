<?php

namespace Payavel\Contracts;

interface Providable
{
    /**
     * Get the provider's id.
     *
     * @return int
     */
    public function getId();

    /**
     * Get the provider's name.
     */
    public function getName();
}
