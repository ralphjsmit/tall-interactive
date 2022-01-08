<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait HasValidation
{
    use RegisterMessages;

    public function registerFormMessages(): void
    {
        $this->registerMessages(
            $this->call('getErrorMessages')
        );
    }
}
