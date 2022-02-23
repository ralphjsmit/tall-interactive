<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait HasValidation
{
    use RegisterMessages;

    public function registerFormMessages(): void
    {
        $this->registerMessages(
            method_exists($this->formClass, 'getErrorMessages')
                ? collect($this->call('getErrorMessages'))
                ->mapWithKeys(function (string $message, string $key): array {
                    return [$this->form->getStatePath() . '.' . $key => $message];
                })
                ->all()
                : []
        );
    }
}
