<?php

namespace RalphJSmit\Tall\Interactive\Forms;

use Livewire\Component;

class Form implements ToForm
{
    public static function getFormSchema(Component $livewire = null): array
    {
        return [];
    }

    public static function getFormDefaults(): array
    {
        return [];
    }

    public static function submitForm(FormData $formData, Component $livewire = null): void
    {
        //
    }
}
