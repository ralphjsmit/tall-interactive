<?php

use RalphJSmit\Tall\Interactive\Forms\FormData;

it('can set the correct values from an array', function () {
    $values = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'age' => 25,
    ];

    $formData = new FormData($values);

    expect($formData)
        ->name->toBe('John Doe')
        ->email->toBe('john@example.com')
        ->age->toBe(25);

    expect($formData->toArray())
        ->toBe($values);

    $formData->email = 'john-doe@example.com';

    expect($formData)
        ->name->toBe('John Doe')
        ->email->toBe('john-doe@example.com')
        ->age->toBe(25);
});
