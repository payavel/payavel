<?php

namespace Payavel\Traits;

trait Questionable
{
    /**
     * Ask for the name of the payment entity (provider, merchant, etc...) to be added.
     *
     * @param string $entity
     * @return string
     */
    protected function askName($entity)
    {
        return $this->ask("What payment {$entity} would you like to add?");
    }

    /**
     * Ask for the id of the payment entity (provider, merchant, etc...) to be added.
     *
     * @param string $entity
     * @param string $name
     * @return string
     */
    protected function askId($entity, $name)
    {
        return $this->ask(
            "How would you like to identify the {$name} payment {$entity}?",
            preg_replace('/[^a-z0-9]+/i', '_', strtolower($name))
        );
    }
}
