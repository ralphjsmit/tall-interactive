<?php

namespace RalphJSmit\Tall\Interactive\Livewire;

use Livewire\Component;

abstract class Actionable extends Component
{
    protected $listeners = [];

    public function close()
    {
        $this->emit("{$this->actionableType}:close", $this->actionableId);
    }

    public function forceClose()
    {
        $this->emit('actionables:forceClose');
    }
}
