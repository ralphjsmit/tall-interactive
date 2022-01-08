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

    public bool $formInitialized = false;

    public function mountHasForm(string $maxWidth = null)
    {
        $this->maxWidth = $maxWidth ?? '2xl';
    }

    public function runFormInitialization(string $actionable, $params)
    {
        if ( $this->actionableId !== $actionable ) {
            return;
        }

        if ( ! $this->formInitialized ) {
            return;
        }

        $params = collect($params)->mapWithKeys(function ($item, $key) {
            return ["formParam{$key}" => $item];
        })->all();

        $this->call('initialize', $params);
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

        if ( ! $this->model ) {
            $this->initializeForm();
        }
    }

    public function getFormSchema(): array
    {
        $formSchema = $this->call('getFormSchema');

        $this->setDefaultProperties();

        $this->registerFormMessages();

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
