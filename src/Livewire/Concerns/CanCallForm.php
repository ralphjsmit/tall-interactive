<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

use Closure;

trait CanCallForm
{
    public function getDefaultCallableParameters(): array
    {
        $parameters = collect([
            'close' => fn (string $actionable = null) => $this->close($actionable),
            'forceClose' => fn () => $this->forceClose(),
            'formClass' => $this->formClass,
            'formVersion' => $this->formVersion,
            'livewire' => $this,
            'model' => $this->model,
            'modelPathIfGiven' => $this->model ? 'model.' : '',
            'params' => $this->params,
        ]);

        return $parameters->all();
    }

    protected function call(string|Closure $method, array $parameters = []): mixed
    {
        if ( is_string($method) ) {
            if ( ! $this->formClass || ! method_exists($this->formClass, $method) ) {
                return null;
            }
        }

        return app()->call(
            callback: is_string($method) ? [$this->formClass, $method] : $method,
            parameters: array_merge($this->getDefaultCallableParameters(), $parameters)
        );
    }
}
