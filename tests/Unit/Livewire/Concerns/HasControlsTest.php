<?php

use Livewire\Livewire;

it('can display the controls', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-modal',
        'form' => TestForm::class,
        'dismissableWith' => 'Close',
    ]);

    $component
        ->assertSet('showControls', true)
        ->assertSee('Close')
        ->assertSee('Submit');
})->with('stateful_actionables');

it('cannot display the controls if not allowed', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-modal',
        'form' => TestForm::class,
        'dismissableWith' => 'Close',
        'hideControls' => true,
    ]);

    $component
        ->assertSet('showControls', false)
        ->assertDontSee('id="tall-interactive-slide-over-controls"', false);
})->with('stateful_actionables');
