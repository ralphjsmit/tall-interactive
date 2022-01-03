<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait CanCallForm
{
    private function call(string $method, array $parameters = [])
    {
        return app()->call(
            [$this->formClass, $method],
            array_merge([
                'livewire' => $this,
                'record' => $this->record,
                'recordPathIfGiven' => $this->record ? 'record.' : '',
            ], $parameters)
        );
    }
}
