<?php

use Filament\Forms\Components\TextInput;
use Livewire\Component;
use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\Forms\Form;
use RalphJSmit\Tall\Interactive\Livewire\Modal;

it('can open the modal', function () {
    $component = Livewire::test(Modal::class, ['id' => 'test-modal']);

    $component
        ->emit('actionable:open', 'test-modal')
        ->assertSet('actionableOpen', true);

    $component
        ->emit('actionable:close', 'test-modal')
        ->assertSet('actionableOpen', false);
});

it('will not open the modal for another identifier', function () {
    $component = Livewire::test(Modal::class, ['id' => 'test-modal']);

    $component
        ->emit('actionable:open', 'another-modal')
        ->assertSet('actionableOpen', false);

    $component
        ->emit('actionable:close', 'another-modal')
        ->assertSet('actionableOpen', false);
});

it('can contain the form', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => '',

    ]);
});

it('will store the maxWidth', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'maxWidth' => '7xl',
    ]);

    $component
        ->emit('actionable:open', 'test-modal')
        ->assertSet('maxWidth', '7xl');
});

it('can receive and display a form component', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => UserForm::class,
    ]);

    $component
        ->assertSet('formClass', UserForm::class);

    $component
        ->assertSee('email')
        ->assertSee('Enter your e-mail');
});

class UserForm extends Form
{
    public static function getFormSchema(Component $livewire = null): array
    {
        return [
            TextInput::make('email')->label('Enter your e-mail'),
        ];
    }
}
