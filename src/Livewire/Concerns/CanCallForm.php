<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait CanCallForm
{
    private function call(string $method, array $parameters = [])
    {
        if (! method_exists($this->formClass, $method)) {
            return;
        }

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
