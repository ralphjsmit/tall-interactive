<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait Closeable
{
    use RegisterListeners;

    public bool $closeOnSubmit = false;
}
