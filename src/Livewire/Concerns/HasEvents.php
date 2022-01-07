<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait HasEvents
{
    public function close(string $actionable = null)
    {
        $this->emit(':close', $actionable ?? $this->actionableId);
    }

    public function forceClose()
    {
        $this->emit('actionables:forceClose');
    }
}
