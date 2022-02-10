<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait Closeable
{
    use RegisterListeners;

    public bool $closeOnSubmit = false;
    public bool $forceCloseOnSubmit = false;
    public string $submitWith = 'Submit';

    public function handleCloseOnSubmit(): void
    {
        if ($this->forceCloseOnSubmit) {
            $this->forceClose();

            return;
        }

        if ($this->closeOnSubmit) {
            $this->close();
        }
    }
}
