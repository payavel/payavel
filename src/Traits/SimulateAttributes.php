<?php

namespace Payavel\Traits;

use Illuminate\Support\Str;

trait SimulateAttributes
{
    /**
     * The magic attributes array.
     *
     * @var array
     */
    protected array $attributes = [];

    /**
     * Checks if a get method exists and excecutes, otherwise returns value from the $attributes array.
     *
     * @param string $key.
     * @return mixed
     */
    public function __get($key)
    {
        if (! method_exists(self::class, $method = 'get' . Str::studly($key))) {
            return $this->getAttribute($key);
        }

        return $this->$method();
    }

    /**
     * Checks if a set method exists and excecutes, otherwise sets value in the $attributes array.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set($key, $value): void
    {
        if (! method_exists(self::class, $method = 'set' . Str::studly($key))) {
            $this->setAttribute($key, $value);

            return;
        }

        $this->$method($value);
    }

    /**
     * Get an attribute from the $attributes array.
     *
     * @param string $key
     * @return mixed
     */
    protected function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Sets a value in the $attributes array.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    protected function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }
}
