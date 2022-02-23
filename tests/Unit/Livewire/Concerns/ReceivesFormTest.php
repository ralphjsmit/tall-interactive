<?php

use Filament\Forms\Components\TextInput;
use Illuminate\Testing\Assert;
use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\Forms\Form;

it('can receive a form version', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => TestForm::class,
        'formVersion' => 'create',
    ]);

    $component
        ->assertSet('formVersion', 'create');
})->with('stateful_actionables');

it('can get a callable from the above methods', function (string $livewire) {
    ExpectFormversionTest::$expectedFormVersion = 'create';

    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => ExpectFormversionTest::class,
        'formVersion' => 'create',
    ]);

    $component
        ->assertSet('formVersion', 'create')
        ->set('data.email', 'john@example.com')
        ->call('submitForm')
        ->assertHasNoErrors();
})->with('actionables');

class ExpectFormversionTest extends Form
{
    public static string $expectedFormVersion = '';

    public function getFormSchema(): array
    {
        return [TextInput::make('email')->email()->required()];
    }

    public function SubmitForm(Closure $close, Closure $forceClose, string $formVersion): void
    {
        Assert::assertSame(static::$expectedFormVersion, $formVersion);
    }
}

it('can store a form object instead of the class', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => TestForm::class,
    ]);

    $component
        ->assertSet('formClass', fn ($value): bool => $value instanceof TestForm);
})->with('actionables');
