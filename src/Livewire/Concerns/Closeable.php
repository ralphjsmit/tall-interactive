<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait Closeable
{
    use RegisterListeners;

    public bool $closeOnSubmit = true;

    public function handleCloseOnSubmit(string $modalType)
    {
        if ($this->closeOnSubmit) {
            $this->emit("{$modalType}:close");
        }
    }
}
