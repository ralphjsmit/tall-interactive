<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait HasEvents
{
    public function close(string $actionable = null): void
    {
        $this->emit(':close', $actionable ?? $this->actionableId);
    }

    public function forceClose(): void
    {
        $this->emit('actionables:forceClose');
    }
}
