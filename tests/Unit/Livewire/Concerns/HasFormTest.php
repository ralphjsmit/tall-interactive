<?php

use Livewire\Livewire;

beforeEach(function () {
    AdditionalFormParametersTestForm::$initializedTimes = 0;
    AdditionalFormParametersTestForm::$params = [];
});

it('can pass additional parameters to the form class', function (string $livewire) {
    expect(AdditionalFormParametersTestForm::$initializedTimes)->toBe(0);
    expect(AdditionalFormParametersTestForm::$params)->toBe([]);

    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => AdditionalFormParametersTestForm::class,
        'dismissableWith' => 'Close',
        'submitWith' => 'Submit form',
        'params' => [
            'foo' => 'bar',
        ],
    ]);

    $component
        ->assertSee('Close')
        ->emit('actionable:open', 'test-actionable');

    expect(AdditionalFormParametersTestForm::$initializedTimes)->toBe(1);
    expect(AdditionalFormParametersTestForm::$params)->toBe([
        'foo' => 'bar',
    ]);
})->with('actionables');
