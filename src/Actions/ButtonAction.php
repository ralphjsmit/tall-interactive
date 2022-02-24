<?php

namespace RalphJSmit\Tall\Interactive\Actions;

use Closure;

class ButtonAction
{
    protected Closure $action;

    protected string $label = '';

    protected string $name = '';

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
}
