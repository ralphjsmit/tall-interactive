<?php

namespace RalphJSmit\Tall\Interactive\Forms;

use Livewire\Wireable;

class Form implements Wireable
{
    public function __construct(array $properties = [],)
    {
        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }
    }

    public static function fromLivewire($value): self
    {
        $formClass = $value['_formClass'];

        return new $formClass($value);
    }

    public function toLivewire(): array
    {
        return array_merge(get_object_vars($this), [
            '_formClass' => static::class,
        ]);
    }
}
