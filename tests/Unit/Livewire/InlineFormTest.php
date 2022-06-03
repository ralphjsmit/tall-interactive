<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\Livewire\InlineForm;

it('can display the inline-form', function () {
    $component = Livewire::test(InlineForm::class, [
        'form' => TestForm::class,
    ]);

    $component
        ->assertSee('form');
});

it('can display the inline-form in an container', function () {
    $component = Livewire::test(InlineForm::class, [
        'form' => TestForm::class,
    ]);

    $component
        ->assertViewHas('container', false)
        ->assertViewHas('controlsDesign', 'minimal');
});

it('will display the title', function () {
    $component = Livewire::test(InlineForm::class, [
        'title' => 'Great modal title',
    ]);

    $component
        ->assertSee('Great modal title');
});

it('will display the description', function () {
    $component = Livewire::test(InlineForm::class, [
        'description' => 'This is a sentence to describe the modal.',
    ]);

    $component
        ->assertSee('This is a sentence to describe the modal.');
});

it('can receive an Eloquent record', function () {
    $user = new class () extends Model {
        public $email = 'john@example.com';

        public $password = 'password';
    };

    UserForm::$expectedUser = $user;

    $component = Livewire::test(InlineForm::class, [
        'model' => $user,
        'form' => UserForm::class,
    ]);

    $component
        ->assertSet('model', $user)
        ->assertSet('model.email', 'john@example.com')
        ->call('submit')
        ->assertSet('model.email', 'john@example.com');
});

it('can receive an htmlstring', function () {
    $html = '<p>This is a paragraph</p>';
    $slot = new HtmlString($html);

    $component = Livewire::test(InlineForm::class, [
        'slot' => $slot,
    ]);

    $component
        ->assertSet('slot', $slot)
        ->assertSee($html, false);
});

it('form will be prioritised above slot', function () {
    $html = '<p>This is a paragraph</p>';
    $slot = new HtmlString($html);

    $component = Livewire::test(InlineForm::class, [
        'slot' => $slot,
        'form' => UserForm::class,
    ]);

    $component
        ->assertSet('slot', $slot)
        ->assertDontSee($html);
});
