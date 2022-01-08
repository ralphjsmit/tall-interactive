<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait HasValidation
{
    use RegisterMessages;

    public function registerFormMessages(): void
    {
        $this->registerMessages(
            method_exists($this->formClass, 'getErrorMessages') ? $this->call('getErrorMessages') : []
        );
    }
}
