<?php

use Illuminate\Database\Eloquent\Model;
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
        ->assertEmitted(':close', 'test-modal')
        ->assertNotEmitted('actionables:forceClose');
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

it('can forceClose actionables on submit', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => TestForm::class,
        'forceCloseOnSubmit' => true,
    ]);

    $component
        ->emit('actionable:open', 'another-modal')
        ->assertSet('actionableOpen', false)
        ->emit('actionable:open', 'test-modal')
        ->assertSet('actionableOpen', true)
        ->set('data.email', 'john@example.com')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertEmitted('actionables:forceClose');
});

it('can contain the form', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => '',
    ]);

    $component->assertOk();
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
        ->assertSet('formClass', fn($value): bool => $value instanceof TestForm)
        ->assertSee('email')
        ->assertSee('Enter your e-mail');

    $component
        ->assertSet('data.email', '')
        ->assertSet('data.year', 2000)
        ->call('submit')
        ->assertHasErrors()
        ->set('data.email', 'rjs@ralphjsmit.com')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertNotSet('data.email', 'rjs@ralphjsmit.com');

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
        ->set('data.email', 'rjs@ralphjsmit.com')
        ->call('submit')
        ->assertEmitted(':close', 'test-modal')
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
        ->set('data.email', 'rjs@ralphjsmit.com')
        ->call('submit')
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
    $user = new class () extends Model {
        public $email = 'john@example.com';
        public $password = 'password';
    };

    UserForm::$expectedUser = $user;

    $component = Livewire::test(Modal::class, [
        'id' => 'test-slide-over',
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
