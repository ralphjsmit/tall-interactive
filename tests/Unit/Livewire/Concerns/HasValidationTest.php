<?php

use Filament\Forms\Components\TextInput;
use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\Forms\Form;

it('can render a Livewire component', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => TestValidationForm::class,
    ]);

    $component
        ->call('submitForm')
        ->assertHasErrors(['data.email' => 'required'])
        ->assertSee('EMAIL_REQUIRED_MESSAGE')
        ->set('data.email', 'rjs@ralphjsmit.com')
        ->call('submitForm')
        ->assertHasNoErrors(['data.email' => 'required'])
        ->call('submitForm')
        ->assertHasErrors(['data.number' => 'required'])
        ->assertSee('NUMBER_REQUIRED_MESSAGE')
        ->set('data.number', '0x539')
        ->call('submitForm')
        ->assertHasErrors(['data.number' => 'numeric'])
        ->assertSee('NUMBER_NUMERIC_MESSAGE')
        ->set('data.number', '12345')
        ->call('submitForm')
        ->assertHasNoErrors();
})->with('actionables');

class TestValidationForm extends Form
{
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->required(),
            TextInput::make('number')
                ->rules(['numeric'])
                ->required(),
        ];
    }

    public function getErrorMessages(): array
    {
        return [
            'email.required' => 'EMAIL_REQUIRED_MESSAGE',
            'number.required' => 'NUMBER_REQUIRED_MESSAGE',
            'number.numeric' => 'NUMBER_NUMERIC_MESSAGE',
        ];
    }
}
