<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

use Filament\Forms\Concerns\InteractsWithForms;

trait HasForm
{
    use CanCallForm;
    use Closeable;
    use HasModel;
    use HasValidation;
    use InteractsWithForms;
    use RegisterListeners;

    public bool $formMounted = false;
    public array $params = [];

    public function mountHasForm(string $maxWidth = null): void
    {
        $this->maxWidth = $maxWidth ?? '2xl';
    }

    public function runFormInitialization(string $actionable, $params): void
    {
        if ( $this->actionableId !== $actionable ) {
            return;
        }

        $this->call('onOpen', [
            'eventParams' => $params ?? [],
        ]);
    }

    public function submitForm(): void
    {
        $this->call('submitForm', [
            'formData' => collect($this->form->getState()),
        ]);

        $this->handleFormSubmitted();
    }

    private function handleFormSubmitted(): void
    {
        $this->handleCloseOnSubmit();

        if ( ! $this->model ) {
            $this->initializeForm();
        }
    }

    public function getFormSchema(): array
    {
        $formSchema = $this->call('getFormSchema');

        $this->setDefaultProperties();

        $this->registerFormMessages();

        if ( ! $this->formMounted ) {
            $this->call('mount');

            $this->formMounted = true;
        }

        return $formSchema;
    }

    private function setDefaultProperties(): void
    {
        if ( $this->formMounted ) {
            return;
        }

        if ( $this->formClass ) {
            $this->initializeForm();
        }
    }

    private function initializeForm(): void
    {
        $formDefaults = $this->call('getFormDefaults');

        foreach ($formDefaults as $property => $value) {
            $this->{$property} = $value;
        }

        $this->formInitialized = true;
    }
}
