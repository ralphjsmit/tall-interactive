<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

use Illuminate\Support\HtmlString;

trait HasSlot
{
    public string $slot = '';

    public function mountHasSlot(HtmlString $slot)
    {
        $this->slot = $slot->toHtml();
    }

    public function submitSlot()
    {
        $this->close();
    }
}
