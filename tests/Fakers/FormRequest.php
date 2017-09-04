<?php

namespace Tests\Fakers;

class FormRequest
{
    private $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = collect($attributes);
    }

    public function get($key)
    {
        return $this->attributes->get($key);
    }

    public function has($key)
    {
        return $this->attributes->has($key);
    }
}