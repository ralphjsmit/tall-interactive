<?php

use Livewire\Livewire;

it('can emit :close event on submitting the slot', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => TestForm::class,
    ]);

    $component
        ->call('submitSlot')
        ->assertEmitted(':close', 'test-actionable');
})->with('stateful_actionables');

it('cannot emit :close event on submitting the slot if that isn\'t allowed', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => TestForm::class,
        'closeOnSubmit' => false,
    ]);

    $component
        ->call('submitSlot')
        ->assertNotEmitted(':close');
})->with('actionables');

it('can emit actionables:forceClose event on submitting the slot', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => TestForm::class,
        'forceCloseOnSubmit' => true,
    ]);

    $component
        ->call('submitSlot')
        ->assertEmitted('actionables:forceClose');
})->with('actionables');
