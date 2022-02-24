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
        ->call('submit')
        ->assertHasErrors(['data.email' => 'required'])
        ->assertSee('EMAIL_REQUIRED_MESSAGE')
        ->set('data.email', 'rjs@ralphjsmit.com')
        ->call('submit')
        ->assertHasNoErrors(['data.email' => 'required'])
        ->call('submit')
        ->assertHasErrors(['data.number' => 'required'])
        ->assertSee('NUMBER_REQUIRED_MESSAGE')
        ->set('data.number', '0x539')
        ->call('submit')
        ->assertHasErrors(['data.number' => 'numeric'])
        ->assertSee('NUMBER_NUMERIC_MESSAGE')
        ->set('data.number', '12345')
        ->call('submit')
        ->assertHasNoErrors();
})->with('actionables');

class TestValidationForm extends Form
{
    public function getErrorMessages(): array
    {
        return [
            'email.required' => 'EMAIL_REQUIRED_MESSAGE',
            'number.required' => 'NUMBER_REQUIRED_MESSAGE',
            'number.numeric' => 'NUMBER_NUMERIC_MESSAGE',
        ];
    }

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
}
