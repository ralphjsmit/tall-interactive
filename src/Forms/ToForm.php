<?php

namespace RalphJSmit\Tall\Interactive\Forms;

use Illuminate\Support\Collection;
use Livewire\Component;

interface ToForm
{
    public static function getFormSchema(Component $livewire = null): array;

    public static function submitForm(Collection $formData, Component $livewire = null): void;
}
