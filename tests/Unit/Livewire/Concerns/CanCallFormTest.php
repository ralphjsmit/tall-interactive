<?php

use Livewire\Livewire;

it('can return the default parameters for calling forms', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => TestForm::class,
    ]);

    $parameters = $component->instance()->getDefaultCallableParameters();
    //
})->with('actionables');

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

it('can pass the form instance when doing dependency injection', function (string $livewire) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => DependencyInjectionTestForm::class,

    ]);
    expect($component->get('formClass'))
        ->submittedTimes->toBe(0);

    $component
        ->call('submit');

    expect($component->get('formClass'))
        ->submittedTimes->toBe(1);
})->with('actionables');
