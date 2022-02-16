<?php

namespace RalphJSmit\Tall\Interactive\Forms;

use Illuminate\Support\Arr;
use Livewire\Wireable;

class Form implements Wireable
{
    public function __construct(array $properties = [], )
    {
        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }
    }

    public static function fromLivewire($value): self
    {
        $formClass = Arr::pull($value, '_formClass');

        return app($formClass, ['properties' => $value]);
    }

    public function toLivewire(): array
    {
        return array_merge(get_object_vars($this), [
            '_formClass' => static::class,
        ]);
    }
}
