<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait HasState
{
    public bool $actionableOpen = false;

    public function initializeHasState(): void
    {
        $this->listeners = array_merge(
            $this->listeners,
            [
                'actionable:open' => 'openActionable',
                'actionable:close' => 'closeActionable',
            ],
        );
    }

    public function openActionable(string $actionable): void
    {
        if ($this->actionableId === $actionable) {
            $this->actionableOpen = true;
        }
    }

    public function closeActionable(string $actionable): void
    {
        if ($this->actionableId === $actionable) {
            $this->actionableOpen = false;
        }
    }
}
