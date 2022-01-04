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
            $this->actionableOpen = true;
        }
    }

    public function closeActionable(string $actionable): void
    {
        if ( $this->actionableId === $actionable ) {
            $this->actionableOpen = false;
        }
    }
}
