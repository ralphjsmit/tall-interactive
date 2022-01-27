<?php

namespace RalphJSmit\Tall\Interactive\Livewire;

use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\CanBeDismissed;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\Closeable;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasControls;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasDescription;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasEvents;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasForm;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasLivewire;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasMaxWidth;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasModel;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasSlot;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasState;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasTitle;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\ReceivesForm;

class SlideOver extends Actionable implements HasForms
{
    use ReceivesForm;
    use HasForm;
    use CanBeDismissed;
    use Closeable;
    use HasControls;
    use HasDescription;
    use HasEvents;
    use HasLivewire;
    use HasMaxWidth;
    use HasModel;
    use HasState;
    use HasSlot;
    use HasTitle;

    public string $actionableId;
    public string $actionableType = 'slideOver';

    public function mount(string $id)
    {
        $this->actionableId = $id;
    }

    public function render(): View|Factory
    {
        return view('tall-interactive::livewire.slide-over');
    }
}
