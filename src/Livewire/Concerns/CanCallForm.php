<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

use Closure;

trait CanCallForm
{
    protected function call(string|Closure $method, array $parameters = []): mixed
    {
        dump($method);
        if ( is_string($method) ) {
            if ( ! $this->formClass || ! method_exists($this->formClass, $method) ) {
                return null;
            }
        }

        return app()->call(
            is_string($method) ? [$this->formClass, $method] : $method,
            array_merge($this->getDefaultCallableParameters(), $parameters)
        );
    }

    public function getDefaultCallableParameters(): array
    {
        return [
            'close' => fn (string $actionable = null) => $this->close($actionable),
            'forceClose' => fn () => $this->forceClose(),
            'form' => $this->form ?? null,
            'formClass' => $this->formClass,
            'formVersion' => $this->formVersion,
            'livewire' => $this,
            'model' => $this->model,
            'modelPathIfGiven' => $this->model ? 'model.' : '',
            'params' => $this->params,
        ];
    }
}
