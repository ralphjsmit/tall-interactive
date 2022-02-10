<?php

namespace RalphJSmit\Tall\Interactive\Forms;

use Livewire\Wireable;

class FormData implements Wireable
{
    public function __construct(array $properties = [])
    {
        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }
    }

    public function toLivewire(): array
    {
        return $this->toArray();
    }

    public static function fromLivewire($value)
    {
        ray($value)->label('From livewire');

        return new static($value);
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
