<?php

namespace RalphJSmit\Tall\Interactive\Actions;

use Closure;

class ButtonAction
{
    protected Closure $action;

    protected string $label = '';

    protected string $color = 'secondary';

    protected string $name = '';

    protected bool|Closure $isHidden = false;

    protected bool|Closure $isVisible = true;

    public static function make(string $name): static
    {
        return ( new static() )->name($name);
    }

    public function action(Closure $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getAction(): Closure
    {
        return $this->action;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isHidden(): bool
    {
        if ($this->evaluate($this->isHidden)) {
            return true;
        }

        return ! $this->evaluate($this->isVisible);
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function visible(bool|Closure $condition): static
    {
        $this->isVisible = $condition;

        return $this;
    }

    public function hidden(bool|Closure $condition): static
    {
        $this->isHidden = $condition;

        return $this;
    }

    protected function evaluate(mixed $value): mixed
    {
        if ($value instanceof Closure) {
            return app()->call($value);
        }

        return $value;
    }

    public function color(string $color): static
    {
        if (in_array($color, ['secondary', 'danger'])) {
            $this->color = $color;
        }

        return $this;
    }

    public function getColor(): string
    {
        return $this->color;
    }
}
