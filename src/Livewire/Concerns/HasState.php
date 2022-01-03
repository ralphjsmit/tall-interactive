<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait HasState
{
    use RegisterListeners;

    public bool $actionableOpen = false;

    public function initializeHasState(): void
    {
        $this->registerListeners([
            'actionable:open' => 'openActionable',
            'actionable:close' => 'closeActionable',
        ]);
    }

    public function openActionable(string $actionable): void
    {
        if ( $this->actionableId === $actionable ) {
            ray($this->actionableId);
            $this->actionableOpen = true;
            ray($this)->label('Opening actionable');
        }
    }

    public function closeActionable(string $actionable): void
    {
        if ( $this->actionableId === $actionable ) {
            ray($this->actionableId);
            $this->actionableOpen = false;
            ray($this);
        }
    }
}
