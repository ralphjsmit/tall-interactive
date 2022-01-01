<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

use Filament\Forms\Concerns\InteractsWithForms;
use RalphJSmit\Tall\Interactive\Forms\FormData;

trait HasForm
{
    use InteractsWithForms;

    public FormData $formData;
    public string $prefix = 'formData.';

    public function mountHasForm(string $maxWidth = null)
    {
        $this->maxWidth = $maxWidth ?? '2xl';
    }

    public function submitForm(): void
    {
        $this->formClass::submitForm(livewire: $this, formData: $this->formData);
    }

    public function getFormSchema(): array
    {
        $formSchema = $this->formClass::getFormSchema(livewire: $this,);

        $properties = [];

        foreach ($formSchema as $formComponent) {
            $name = $formComponent->getName();

            $formComponent
                ->name($this->prefix . $name)
                ->statePath($this->prefix . $name);
        }

        $this->getFormDefaults();

        return $formSchema;
    }

    public function getFormDefaults(): array
    {
        $formDefaults = $this->formClass::getFormDefaults();

        $properties = [];

        foreach ($formDefaults as $property => $value) {
            $properties[$property] = $value;
        }

        if ( ! isset($this->formData) ) {
            $this->formData = new FormData($properties);
        }

        return $properties;
    }

    //    public function __get($property)
    //    {
    //        $formDefaults = $this->getFormDefaults();
    //
    //        if ( $property === 'form' ) {
    //            return $this->form;
    //        }
    //
    //        if ( array_key_exists($property, $formDefaults) ) {
    //            if ( property_exists($this, $property) ) {
    //                return $this->$property;
    //            } else {
    //                return $formDefaults[$property];
    //            }
    //        }
    //
    //        return $this->$property;
    //    }
}
