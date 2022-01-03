<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait RegisterListeners
{
    private function registerListeners(array $listeners)
    {
        $this->listeners = array_merge($this->listeners, $listeners);
    }
}
