<?php

namespace RalphJSmit\Tall\Interactive\Livewire;

use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasControls;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasDescription;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasDesign;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasEvents;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasForm;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasLivewire;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasMaxWidth;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasModel;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasSlot;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasTitle;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\ReceivesForm;

class InlineForm extends Actionable implements HasForms
{
    use ReceivesForm;
    use HasForm;
    use HasControls;
    use HasDescription;
    use HasDesign;
    use HasEvents;
    use HasLivewire;
    use HasMaxWidth;
    use HasModel;
    use HasSlot;
    use HasTitle;

    public ?string $actionableId;
    public string $actionableType = 'inlineForm';

    public function mount(string $id = null)
    {
        $this->actionableId = $id;
    }

    public function render(): View|Factory
    {
        return view('tall-interactive::livewire.inline-form');
    }
}
