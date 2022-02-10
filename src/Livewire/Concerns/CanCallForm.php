<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait CanCallForm
{
    private function call(string $method, array $parameters = []): mixed
    {
        if ( ! method_exists($this->formClass, $method) ) {
            return null;
        }

        return app()->call(
            [$this->formClass, $method],
            array_merge([
                'close' => fn (string $actionable = null) => $this->close($actionable),
                'forceClose' => fn () => $this->forceClose(),
                'formVersion' => $this->formVersion,
                'livewire' => $this,
                'model' => $this->model,
                'modelPathIfGiven' => $this->model ? 'model.' : '',
            ], $parameters)
        );
    }
}
