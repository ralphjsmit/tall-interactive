<?php

use Livewire\Component;
use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\Actions\ButtonAction;

beforeEach(function () {
    MountTestForm::$mountedTimes = 0;
    AdditionalFormParametersTestForm::$initializedTimes = 0;
    AdditionalFormParametersTestForm::$params = [];
});

it('can mount actionables', function (string $actionable) {
    $user = User::make(['email' => 'john@example.com']);

    MountTestForm::$expectedModel = $user;

    expect(MountTestForm::$mountedTimes)->toBe(0);

    $component = Livewire::test($actionable, [
        'id' => 'test-actionable',
        'form' => MountTestForm::class,
        'params' => [
            'x' => 'test',
            'y' => 64,
            'z' => 'true',
        ],
        'model' => $user,
    ]);

    $component
        ->assertSet('form', fn ($value) => $value !== null)
        ->assertSet('data.test', 'FILLED_FORM_VALUE')
        ->call('submit')
        ->call('submit');

    expect(MountTestForm::$mountedTimes)->toBe(1);
})->with('actionables');

it('can open the stateful actionable and initialize it', function (string $actionable) {
    $component = Livewire::test($actionable, [
        'id' => 'test-actionable',
        'form' => InitializationTestForm::class,
    ]);

    $user = User::make(['email' => 'john@example.com']);

    InitializationTestForm::$expectedFirstParam = 1;
    InitializationTestForm::$expectedSecondParam = 'randomParameter';
    InitializationTestForm::$expectedThirdParam = $user;
    InitializationTestForm::$initializedTimes = 0;

    $component
        ->assertSet('form', fn ($value) => $value !== null)
        ->emit('actionable:open', 'test-actionable', 1, 'randomParameter', $user)
        ->assertSet('actionableOpen', true);

    expect(InitializationTestForm::$initializedTimes)->toBe(1);

    $component
        ->emit('actionable:close', 'test-actionable')
        ->emit('actionable:open', 'test-actionable', 1, 'randomParameter', $user);

    expect(InitializationTestForm::$initializedTimes)->toBe(2);
})->with('stateful_actionables');

it('can pass additional parameters to the form class', function (string $livewire) {
    expect(AdditionalFormParametersTestForm::$initializedTimes)->toBe(0);
    expect(AdditionalFormParametersTestForm::$params)->toBe([]);

    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => AdditionalFormParametersTestForm::class,
        'title' => 'TITLE',
        'params' => [
            'foo' => 'bar',
        ],
    ]);

    $component
        ->assertSee('TITLE');

    expect(AdditionalFormParametersTestForm::$initializedTimes)->toBe(1);
    expect(AdditionalFormParametersTestForm::$params)->toBe([
        'foo' => 'bar',
    ]);
})->with('actionables');

it('can specify additional buttons with tasks', function (string $livewire) {
    AdditionalButtonsTestForm::$formButtons = [];

    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => AdditionalButtonsTestForm::class,
        'title' => 'TITLE',
    ]);

    $component
        ->assertDontSee('Other Action');

    AdditionalButtonsTestForm::$formButtons = ($buttons = [
        ButtonAction::make('other_action')
            ->action(function (Component $livewire) {
                $livewire->hasExecutedAction = true;
            })
            ->label('Other Action'),
    ]);

    expect($component->instance())
        ->getButtonActions()
        ->toBe($buttons);

    $component
        ->emit('$refresh')
        ->assertSee('Other Action')
        ->call('executeButtonAction', 'other_action')
        ->assertSet('hasExecutedAction', true);
})->with('actionables');
