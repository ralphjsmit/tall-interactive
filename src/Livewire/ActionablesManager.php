<?php

namespace RalphJSmit\Tall\Interactive\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class ActionablesManager extends Component
{
    public array $openedActionables = [];

    protected $listeners = [
        'modal:open' => 'openActionable',
        'modal:close' => 'closeActionable',
        'slideOver:open' => 'openActionable',
        'slideOver:close' => 'closeActionable',
        ':close' => 'closeSingleActionable',
        'actionables:forceClose' => 'forceCloseActionables',
    ];

    public function render(): View
    {
        return view('tall-interactive::livewire.actionables-manager');
    }

    public function closeActionable(): void
    {
        $actionable = array_pop($this->openedActionables);

        $this->emit('actionable:close', $actionable);

        if ( $this->openedActionables ) {
            $this->emit('actionable:open', $this->openedActionables[array_key_last($this->openedActionables)]);
        }
    }

    public function closeSingleActionable(string $actionable): void
    {
        if ( ( $key = array_search($actionable, $this->openedActionables) ) !== false ) {
            $this->emit('actionable:close', $actionable);

            unset($this->openedActionables[$key]);

            $this->openedActionables = array_values($this->openedActionables);

            if ( $this->openedActionables ) {
                $this->emit('actionable:open', $this->openedActionables[array_key_last($this->openedActionables)]);
            }
        }
    }

    public function forceCloseActionables(): void
    {
        foreach ($this->openedActionables as $key => $actionable) {
            $this->emit('actionable:close', $actionable);
            unset($this->openedActionables[$key]);
        }
    }

    public function openActionable(string $actionable, ...$params): void
    {
        if ( $this->openedActionables ) {
            $this->emit('actionable:close', $this->openedActionables[array_key_last($this->openedActionables)]);
        }

        $this->openedActionables[] = $actionable;

        $this->emit('actionable:open', $actionable, ...$params);
    }
}
