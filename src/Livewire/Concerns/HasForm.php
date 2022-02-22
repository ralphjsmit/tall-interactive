<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

use Filament\Forms\Concerns\InteractsWithForms;
use RalphJSmit\Tall\Interactive\Actions\ButtonAction;

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
            $this->mountForm();
        }
    }

    public function getFormSchema(): array
    {
        $this->setDefaultProperties();

        $formSchema = $this->call('getFormSchema');

        $this->registerFormMessages();

        return $formSchema;
    }

    private function setDefaultProperties(): void
    {
        if ( $this->formMounted ) {
            return;
        }

        if ( $this->formClass ) {
            $this->mountForm();
        }
    }

    private function mountForm(): void
    {
        if ( ! $this->formMounted ) {
            $this->call('mount');
        }

        $formDefaults = $this->call('getFormDefaults');

        foreach ($formDefaults as $property => $value) {
            $this->{$property} = $value;
        }

        $this->formMounted = true;
    }

    public function getButtonActions(): array
    {
        return $this->call('getButtonActions') ?: [];
    }

    public function executeButtonAction(string $buttonActionName): void
    {
        collect($this->call('getButtonActions'))
            ->each(function (ButtonAction $buttonAction) use ($buttonActionName): void {
                if ( $buttonAction->getName() !== $buttonActionName ) {
                    return;
                }

                $this->call($buttonAction->getAction());
            });
    }
}
