<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait CanCallForm
{
    protected function call(string $method, array $parameters = []): mixed
    {
        if (! $this->formClass || ! method_exists($this->formClass, $method)) {
            return null;
        }

        return app()->call(
            [$this->formClass, $method],
            array_merge([
                'close' => fn (string $actionable = null) => $this->close($actionable),
                'forceClose' => fn () => $this->forceClose(),
                'formClass' => $this->formClass,
                'formVersion' => $this->formVersion,
                'livewire' => $this,
                'model' => $this->model,
                'modelPathIfGiven' => $this->model ? 'model.' : '',
                'params' => $this->params,
            ], $parameters)
        );
    }
}
