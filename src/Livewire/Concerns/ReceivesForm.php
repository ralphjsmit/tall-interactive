<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

use RalphJSmit\Tall\Interactive\Forms\Form;

trait ReceivesForm
{
    public Form|null $formClass = null;
    public string $formVersion = '';

    public function mountReceivesForm(string $form = null): void
    {
        if ($form) {
            $this->formClass = app($form);
        }
    }
}
