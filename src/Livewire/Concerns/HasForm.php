<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

use Filament\Forms\Concerns\InteractsWithForms;

trait HasForm
{
    use CanCallForm;
    use Closeable;
    use HasRecord;
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

        $this->handleFormSubmitted();
    }

    private function handleFormSubmitted()
    {
        $this->handleCloseOnSubmit();

        if ( $this->record !== null ) {
            $this->initializeForm();
        }
    }

    public function getFormSchema(): array
    {
        $formSchema = $this->call('getFormSchema');

        $this->setDefaultProperties();

        return $formSchema;
    }

    private function setDefaultProperties(): void
    {
        if ( $this->formInitialized ) {
            return;
        }

        if ( $this->formClass ) {
            $this->initializeForm();
        }
    }

    private function initializeForm()
    {
        $formDefaults = $this->call('getFormDefaults');

        foreach ($formDefaults as $property => $value) {
            $this->{$property} = $value;
        }

        $this->formInitialized = true;
    }
}
