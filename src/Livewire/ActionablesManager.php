<?php

namespace RalphJSmit\Tall\Interactive\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ActionablesManager extends Component
{
    public array $openedActionables = [];

    public function mount() {}

    public function render(): View|Factory
    {
        return view('tall-interactive::livewire.actionables-manager');
    }

    protected $listeners = [
        'modal:open' => 'openActionable',
        'modal:close' => 'closeActionable',
        'slideOver:open' => 'openActionable',
        'slideOver:close' => 'closeActionable',
        ':close' => 'closeSingleActionable',
        'actionables:forceClose' => 'forceCloseActionables',
    ];

    public function openActionable(string $actionable, ...$params)
    {
        if ( $this->openedActionables ) {
            $this->emit('actionable:close', $this->openedActionables[array_key_last($this->openedActionables)]);
        }

        $this->openedActionables[] = $actionable;

        $this->emit('actionable:open', $actionable, ...$params);
    }

    public function closeActionable()
    {
        $actionable = array_pop($this->openedActionables);

        $this->emit('actionable:close', $actionable);

        if ( $this->openedActionables ) {
            $this->emit('actionable:open', $this->openedActionables[array_key_last($this->openedActionables)]);
        }
    }

    public function forceCloseActionables()
    {
        foreach ($this->openedActionables as $key => $actionable) {
            $this->emit('actionable:close', $actionable);
            unset($this->openedActionables[$key]);
        }
    }

    public function closeSingleActionable(string $actionable): void
    {
        if ( ( $key = array_search($actionable, $this->openedActionables) ) !== false ) {
            $this->emit('actionable:close', $actionable);

            unset($this->openedActionables[$key]);

            $this->openedActionables = array_values($this->openedActionables);
        }
    }
}
