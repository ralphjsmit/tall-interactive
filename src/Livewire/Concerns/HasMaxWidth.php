<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait HasMaxWidth
{
    public string $maxWidth;

    public function mountHasMaxWidth(string $maxWidth = null)
    {
        $this->maxWidth = $maxWidth ?? '2xl';
    }
}
