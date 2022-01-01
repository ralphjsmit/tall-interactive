<?php

namespace RalphJSmit\Tall\Interactive\Livewire;

use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasForm;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasMaxWidth;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasState;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\ReceivesForm;

class Modal extends Actionable implements HasForms
{
    use HasForm;
    use HasMaxWidth;
    use HasState;
    use ReceivesForm;

    public string $actionableId;

    public function mount(string $id)
    {
        $this->actionableId = $id;
    }

    public function render(): View|Factory
    {
        ray($this);

        return view('tall-interactive::livewire.modal');
    }
}
