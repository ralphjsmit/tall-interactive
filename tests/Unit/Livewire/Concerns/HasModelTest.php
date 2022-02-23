<?php

use Livewire\Livewire;

it('can pass the created model to the form', function (string $livewire) {
    $user = User::make(['email' => 'john@example.com']);

    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'form' => TestForm::class,
        'model' => $user,
    ])->instance();

    $formContainer = $component->form;

    expect($formContainer->getRecord())->toBe($user);
})->with('actionables');
