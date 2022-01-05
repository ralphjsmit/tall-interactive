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

    public function openActionable(string $actionable, ...$params): void
    {
        if ( $this->actionableId !== $actionable ) {
            return;
        }

        $this->actionableOpen = true;

        if ( method_exists($this, 'runFormInitialization') ) {
            $this->runFormInitialization($actionable, $params);
        }
    }

    public function closeActionable(string $actionable): void
    {
        if ( $this->actionableId !== $actionable ) {
            return;
        }

        $this->resetValidation();

        $this->actionableOpen = false;
    }
}
