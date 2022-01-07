<?php

use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\Livewire\Modal;
use RalphJSmit\Tall\Interactive\Livewire\SlideOver;

dataset('actionables', [
    [Modal::class,],
    [SlideOver::class,],
]);

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

