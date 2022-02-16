<?php

namespace RalphJSmit\Tall\Interactive\Forms;

use Livewire\Wireable;

abstract class Form implements Wireable
{
    public function __construct(array $properties = [],)
    {
        dump($properties);
        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }
    }

    public static function fromLivewire($value): self
    {
        return new static($value);
    }

    public function toLivewire(): array
    {
        return get_object_vars($this);
    }
}
