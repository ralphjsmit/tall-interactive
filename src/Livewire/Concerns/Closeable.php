<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait Closeable
{
    use RegisterListeners;

    public bool $closeOnSubmit = false;
    public string $submitWith = 'Submit';

    public function handleCloseOnSubmit()
    {
        if ( $this->closeOnSubmit ) {
            $this->emit("{$this->actionableType}:close", $this->actionableId);
        }
    }
}
