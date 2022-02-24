<?php

use Filament\Forms\Components\TextInput;
use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\Forms\Form;

it('can emit :close event', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => TestForm::class,
    ]);

    $component
        ->call('close')
        ->assertEmitted(':close', 'test-actionable');
})->with('actionables');

it('can emit :close event for custom modal', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => TestForm::class,
    ]);

    $component
        ->call('close', 'another-actionable')
        ->assertNotEmitted(':close', 'test-actionable')
        ->assertEmitted(':close', 'another-actionable');
})->with('actionables');

it('can emit actionables:forceClose event', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => TestForm::class,
    ]);

    $component
        ->call('forceClose')
        ->assertEmitted('actionables:forceClose');
})->with('actionables');

it('can get a callable from the above methods', function (mixed $closeCallableParameters, string $expectedEmittedEventParams, string $livewire) {
    CallableTestForm::$closeCallableParameters = $closeCallableParameters;

    $component = Livewire::test($livewire, [
        'form' => CallableTestForm::class,
        'id' => 'test-actionable',
    ]);

    $component
        ->set('data.email', 'john@example.com')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertEmitted(':close', $expectedEmittedEventParams)
        ->assertEmitted('actionables:forceClose');
})->with([
    [[], 'test-actionable'],
    [['another-actionable'], 'another-actionable'],
])->with('actionables');

class CallableTestForm extends Form
{
    public static array $closeCallableParameters = [];

    public function getFormSchema(): array
    {
        return [TextInput::make('email')->email()->required(),];
    }

    public function submit(Closure $close, Closure $forceClose): void
    {
        $close(...static::$closeCallableParameters);

        $forceClose();
    }
}
