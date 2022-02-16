<?php

use RalphJSmit\Tall\Interactive\Forms\Form;

it('can wire a form class to Livewire', function () {
    $form = new WireableTestForm();

    $form->onOpen([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'age' => 20,
    ]);

    expect(invade($form))
        ->name->toBe('John Doe')
        ->email->toBe('john@example.com')
        ->age->toBe(20);

    expect($form)
        ->test->toBe('TEST');

    $wireable = $form->toLivewire();

    expect($wireable)->toBe([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        // Private properties not accessibe by Form, see comment below.
        //        'age' => 20,
        'test' => 'TEST',
        '_formClass' => WireableTestForm::class,
    ]);

    $wiredForm = WireableTestForm::fromLivewire($wireable);

    expect(property_exists($wiredForm, '_formClass'))->toBeFalse();

    expect($wiredForm)->toBeInstanceOf(WireableTestForm::class);

    expect(invade($wiredForm))
        ->name->toBe('John Doe')
        ->email->toBe('john@example.com');
    // Age not accessible.

    expect($wiredForm)
        ->test->toBe('TEST');
});

class WireableTestForm extends Form
{
    public string $name;
    protected string $email;
    /** Private properties cannot be accessed by the ->toLivewire() method in Form. To fix that, override the ->toLivewire() and static fromLivewire() methods or use protected properties. */
    private int $age;

    public function onOpen(array $params): void
    {
        $this->name = $params['name'];
        $this->email = $params['email'];
        $this->age = $params['age'];

        $this->test = 'TEST';
    }
}
