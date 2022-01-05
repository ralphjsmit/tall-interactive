<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait HasControls
{
    public bool $showControls = true;

    public function mountHasControls(bool $hideControls = null)
    {
        if ($hideControls) {
            $this->showControls = ! $hideControls;
        }
    }
}
