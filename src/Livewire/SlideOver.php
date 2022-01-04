<?php

namespace RalphJSmit\Tall\Interactive\Livewire;

use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\CanBeDismissed;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\Closeable;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasDescription;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasForm;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasMaxWidth;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasRecord;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasSlot;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasState;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\HasTitle;
use RalphJSmit\Tall\Interactive\Livewire\Concerns\ReceivesForm;

class SlideOver extends Actionable implements HasForms
{
    use CanBeDismissed;
    use Closeable;
    use HasForm;
    use HasMaxWidth;
    use HasDescription;
    use HasSlot;
    use HasTitle;
    use HasRecord;
    use HasState;
    use ReceivesForm;

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
