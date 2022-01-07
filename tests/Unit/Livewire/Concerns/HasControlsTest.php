<?php

use Livewire\Livewire;

it('can display the controls', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-modal',
        'form' => TestForm::class,
        'dismissableWith' => 'Close',
        'submitWith' => 'Submit form',
    ]);

    $component
        ->assertSet('showControls', true)
        ->assertSee('Submit form');
})->with('actionables');

it('cannot display the controls if not allowed', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-modal',
        'form' => TestForm::class,
        'dismissableWith' => 'Close form',
        'submitWith' => 'Submit form',
        'hideControls' => true,
    ]);

    $component
        ->assertSet('showControls', false)
        ->assertDontSee('Submit form', false);
})->with('actionables');
