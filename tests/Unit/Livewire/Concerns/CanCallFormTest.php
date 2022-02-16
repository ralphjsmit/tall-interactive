<?php

use Livewire\Livewire;

it('can store properties on the form object', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => TestForm::class,
    ]);

    $component
        ->assertSet('formClass', function ($value) {
            return $value instanceof TestForm;
        });
})->with('actionables');
