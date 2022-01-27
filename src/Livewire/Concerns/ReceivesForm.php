<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait ReceivesForm
{
    public string $formClass = '';
    public string $formVersion = '';

    public function mountReceivesForm(string $form = '')
    {
        $this->formClass = $form;

        $this->form->fill();
    }
}
