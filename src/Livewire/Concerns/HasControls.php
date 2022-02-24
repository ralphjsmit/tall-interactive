<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait HasControls
{
    public bool $showControls = true;

    public function mountHasControls(bool $hideControls = null): void
    {
        if ($hideControls) {
            $this->showControls = ! $hideControls;
        }
    }
}
