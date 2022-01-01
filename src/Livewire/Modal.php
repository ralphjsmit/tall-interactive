<?php

namespace RalphJSmit\Tall\Interactive\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasState;

class Modal extends Actionable
{
    use HasState;

    public function render(): View|Factory
    {
        return view('tall-interactive::livewire.modal');
    }
}
