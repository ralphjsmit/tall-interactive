<?php

namespace RalphJSmit\Tall\Interactive\Livewire;

use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

abstract class Actionable extends Component
{
    use WireToast;

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
