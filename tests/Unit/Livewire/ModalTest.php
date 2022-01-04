<?php

use Illuminate\Support\HtmlString;
use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\Livewire\Modal;

it('can open the modal', function () {
    $component = Livewire::test(Modal::class, ['id' => 'test-modal']);

    $component
        ->emit('actionable:open', 'test-modal')
        ->assertSet('actionableOpen', true);

    $component
        ->emit('actionable:close', 'test-modal')
        ->assertSet('actionableOpen', false)
        ->assertNotEmitted('modal:open')
        ->assertNotEmitted('modal:close')
        ->assertNotEmitted('slideOver:open')
        ->assertNotEmitted('slideOver:close')
        ->assertNotEmitted('actionable:open')
        ->assertNotEmitted('actionable:close');
});

it('can open the actionable', function () {
    $component = Livewire::test(Modal::class, ['id' => 'test-modal']);

    $component
        ->emit('actionable:open', 'test-modal')
        ->assertSet('actionableOpen', true);

    $component
        ->call('close')
        ->assertEmitted('modal:close', 'test-modal');
});

it('will not open the modal for another identifier', function () {
    $component = Livewire::test(Modal::class, ['id' => 'test-modal']);

    $component
        ->emit('actionable:open', 'another-modal')
        ->assertSet('actionableOpen', false);

    $component
        ->emit('actionable:close', 'another-modal')
        ->assertSet('actionableOpen', false);
});

it('can contain the form', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => '',
    ]);
});

it('will set the maxWidth to the correct default', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
    ]);

    $component
        ->emit('actionable:open', 'test-modal')
        ->assertSet('maxWidth', '2xl');
});

it('will store the maxWidth', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'maxWidth' => '7xl',
    ]);

    $component
        ->emit('actionable:open', 'test-modal')
        ->assertSet('maxWidth', '7xl');
});

it('can initialize and submit the form', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => TestForm::class,
    ]);

    TestForm::$submittedTimes = 0;
    expect(TestForm::$submittedTimes)->toBe(0);

    $component
        ->assertSet('formClass', TestForm::class)
        ->assertSee('email')
        ->assertSee('Enter your e-mail');

    $component
        ->assertSet('email', '')
        ->assertSet('year', 2000)
        ->call('submitForm')
        ->assertHasErrors()
        ->set('email', 'rjs@ralphjsmit.com')
        ->call('submitForm')
        ->assertHasNoErrors();

    expect(TestForm::$submittedTimes)->toBe(1);
});

it('can close the form on submit', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => TestForm::class,
        'closeOnSubmit' => true,
    ]);

    $component
        ->emit('actionable:open', 'test-modal')
        ->assertSet('actionableOpen', true);

    $component
        ->set('email', 'rjs@ralphjsmit.com')
        ->call('submitForm')
        ->assertEmitted('modal:close', 'test-modal')
        ->emit('actionable:close', 'test-modal')/* Action performed by ActionablesManager */
        ->assertSet('actionableOpen', false);
});

it('cannot close the form on submit if not allowed', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => TestForm::class,
        'closeOnSubmit' => false,
    ]);

    $component
        ->emit('actionable:open', 'test-modal')
        ->assertSet('actionableOpen', true);

    $component
        ->set('email', 'rjs@ralphjsmit.com')
        ->call('submitForm')
        ->assertNotEmitted('modal:close')
        ->assertSet('actionableOpen', true);
});

it('cannot dismiss the form by default', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => TestForm::class,
    ]);

    $component
        ->assertSet('dismissable', false)
        ->assertDontSee('Close');
});

it('can dismiss the form', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => TestForm::class,
        'dismissable' => true,
    ]);

    $component
        ->assertSet('dismissable', true)
        ->assertSee('Close');
});

it('can dismiss the form with custom text', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => TestForm::class,
        'dismissableWith' => 'Cancel this action',
    ]);

    $component
        ->assertSet('dismissable', true)
        ->assertDontSee('Close')
        ->assertSee('Cancel this action');
});

it('can submit the form with custom text', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => TestForm::class,
        'submitWith' => 'Confirm awesome stuff',
    ]);

    $component
        ->assertDontSee('Close')
        ->assertSee('Confirm awesome stuff');
});

it('cannot dismiss the form if not allowed', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => TestForm::class,
        'dismissable' => false,
    ]);

    $component
        ->assertSet('dismissable', false)
        ->assertDontSee('Close');
});

it('will display the title', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'title' => 'Great modal title',
    ]);

    $component
        ->assertSee('Great modal title');
});

it('will display the description', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'description' => 'This is a sentence to describe the modal.',
    ]);

    $component
        ->assertSee('This is a sentence to describe the modal.');
});

it('can receive an Eloquent record', function () {
    $user = User::make(['email' => 'john@john.com', 'password' => 'password']);

    UserForm::$expectedUser = $user;

    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'record' => $user,
        'form' => UserForm::class,
    ]);

    $component
        ->assertSet('record', $user)
        ->call('submitForm');
});

it('can receive an htmlstring', function () {
    $html = '<p>This is a paragraph</p>';
    $slot = new HtmlString($html);

    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'slot' => $slot,
    ]);

    $component
        ->assertSet('slot', $slot)
        ->assertSee($html, false);
});

it('form will be prioritised above slot', function () {
    $html = '<p>This is a paragraph</p>';
    $slot = new HtmlString($html);

    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'slot' => $slot,
        'form' => UserForm::class,
    ]);

    $component
        ->assertSet('slot', $slot)
        ->assertDontSee($html);
});
