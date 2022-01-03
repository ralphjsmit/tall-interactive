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
        //        ':close' => 'closeActionable',
    ];

    public function openActionable(string $actionable)
    {
        ray($actionable)->label('Received actionable');
        if ( $this->openedActionables ) {
            ray($this->openedActionables[array_key_last($this->openedActionables)])->label("CLose actionable");
            $this->emit('actionable:close', $this->openedActionables[array_key_last($this->openedActionables)]);
        }

        $this->openedActionables[] = $actionable;
        ray($actionable)->label('New actionable:');

        $this->emit('actionable:open', $actionable);
    }

    public function closeActionable()
    {
        $actionable = array_pop($this->openedActionables);

        $this->emit('actionable:close', $actionable);

        if ( $this->openedActionables ) {
            $this->emit('actionable:open', $this->openedActionables[array_key_last($this->openedActionables)]);
        }
    }
}
