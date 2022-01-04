<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

use Filament\Forms\Concerns\InteractsWithForms;
use RalphJSmit\Tall\Interactive\Livewire\ActionablesManager;

trait HasForm
{
    use CanCallForm;
    use Closeable;
    use InteractsWithForms;

    public bool $formInitialized = false;

    public function mountHasForm(string $maxWidth = null)
    {
        $this->maxWidth = $maxWidth ?? '2xl';
    }

    public function submitForm(): void
    {
        $this->call('submitForm', [
            'formData' => $this->form->getState(),
        ]);

        ray('Submit form');
        $this->handleFormSubmitted();
    }

    private function handleFormSubmitted()
    {
        ray('Handle close on submit');

        $this->emitTo(ActionablesManager::class, 'modal:close', $this->actionableId);

        //        if ( $this->closeOnSubmit ) {
        //        }
    }

    public function getFormSchema(): array
    {
        $formSchema = $this->call('getFormSchema');

        $this->setDefaultProperties();

        return $formSchema;
    }

    private function setDefaultProperties(): void
    {
        $formDefaults = $this->call('getFormDefaults');

        if ($this->formInitialized) {
            return;
        }

        if ($this->formClass) {
            foreach ($formDefaults as $property => $value) {
                $this->{$property} = $value;
            }

            $this->formInitialized = true;
        }
    }
}
