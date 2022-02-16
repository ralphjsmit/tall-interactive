<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait ReceivesForm
{
    public $formClass = null;
    public string $formVersion = '';

    public function mountReceivesForm(string $form = null): void
    {
        dump($form);
        if ( $form ) {
            $this->formClass = new $form();
            dump($this->formClass);
        }
    }
}
