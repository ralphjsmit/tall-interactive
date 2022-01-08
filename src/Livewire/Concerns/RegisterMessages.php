<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait RegisterMessages
{
    private function registerMessages(array $messages)
    {
        $this->messages = array_merge($this->messages, $messages);
    }
}
