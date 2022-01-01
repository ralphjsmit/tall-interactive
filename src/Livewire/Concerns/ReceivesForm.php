<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait ReceivesForm
{
    public string $formClass = '';

    public function mountReceivesForm(string $form = '')
    {
        $this->formClass = $form;
    }
}
