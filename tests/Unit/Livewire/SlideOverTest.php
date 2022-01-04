<?php

use Filament\Forms\Components\TextInput;
use Illuminate\Support\HtmlString;
use Illuminate\Testing\Assert;
use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\Forms\Form;
use RalphJSmit\Tall\Interactive\Livewire\SlideOver;

it('can open the modal', function () {
    $component = Livewire::test(SlideOver::class, ['id' => 'test-slide-over']);

    $component
        ->emit('actionable:open', 'test-slide-over')
        ->assertSet('actionableOpen', true);

    $component
        ->emit('actionable:close', 'test-slide-over')
        ->assertSet('actionableOpen', false)
        ->assertNotEmitted('modal:open')
        ->assertNotEmitted('modal:close')
        ->assertNotEmitted('slideOver:open')
        ->assertNotEmitted('slideOver:close')
        ->assertNotEmitted('actionable:open')
        ->assertNotEmitted('actionable:close');
});

it('can open the actionable', function () {
    $component = Livewire::test(SlideOver::class, ['id' => 'test-slide-over']);

    $component
        ->emit('actionable:open', 'test-slide-over')
        ->assertSet('actionableOpen', true);

    $component
        ->call('close')
        ->assertEmitted('slideOver:close', 'test-slide-over');
});

it('will not open the slide-over for another identifier', function () {
    $component = Livewire::test(SlideOver::class, ['id' => 'test-slide-over']);

    $component
        ->emit('actionable:open', 'another-slide-over')
        ->assertSet('actionableOpen', false);

    $component
        ->emit('actionable:close', 'another-slide-over')
        ->assertSet('actionableOpen', false);
});

it('can contain the form', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'form' => '',
    ]);
});

it('will set the maxWidth to the correct default', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
    ]);

    $component
        ->emit('actionable:open', 'test-slide-over')
        ->assertSet('maxWidth', '2xl');
});

it('will store the maxWidth', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'maxWidth' => '7xl',
    ]);

    $component
        ->emit('actionable:open', 'test-slide-over')
        ->assertSet('maxWidth', '7xl');
});

it('can initialize and submit the form', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'form' => SlideOverTestForm::class,
    ]);

    SlideOverTestForm::$submittedTimes = 0;
    expect(SlideOverTestForm::$submittedTimes)->toBe(0);

    $component
        ->assertSet('formClass', SlideOverTestForm::class)
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

    expect(SlideOverTestForm::$submittedTimes)->toBe(1);
});

class SlideOverTestForm extends Form
{
    public static int $submittedTimes = 0;

    public static function getFormSchema(): array
    {
        return [
            TextInput::make('email')->label('Enter your e-mail')->required(),
        ];
    }

    public static function getFormDefaults(): array
    {
        return [
            'email' => '',
            'year' => 2000,
        ];
    }

    public static function submitForm(array $formData, object|null $record): void
    {
        static::$submittedTimes++;
        Assert::assertNull($record);
    }
}

it('can close the form on submit', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'form' => SlideOverTestForm::class,
        'closeOnSubmit' => true,
    ]);

    $component
        ->emit('actionable:open', 'test-slide-over')
        ->assertSet('actionableOpen', true);

    $component
        ->set('email', 'rjs@ralphjsmit.com')
        ->call('submitForm')
        ->assertEmitted('slideOver:close', 'test-slide-over')
        ->emit('actionable:close', 'test-slide-over')/* Action performed by ActionablesManager */
        ->assertSet('actionableOpen', false);
});

it('cannot close the form on submit if not allowed', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'form' => SlideOverTestForm::class,
        'closeOnSubmit' => false,
    ]);

    $component
        ->emit('actionable:open', 'test-slide-over')
        ->assertSet('actionableOpen', true);

    $component
        ->set('email', 'rjs@ralphjsmit.com')
        ->call('submitForm')
        ->assertNotEmitted('modal:close')
        ->assertNotEmitted('slideOver:close')
        ->assertSet('actionableOpen', true);
});

it('cannot dismiss the form by default', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'form' => SlideOverTestForm::class,
    ]);

    $component
        ->assertSet('dismissable', false)
        ->assertDontSee('Close');
});

it('can dismiss the form', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'form' => SlideOverTestForm::class,
        'dismissable' => true,
    ]);

    $component
        ->assertSet('dismissable', true)
        ->assertSee('Close');
});

it('can dismiss the form with custom text', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'form' => SlideOverTestForm::class,
        'dismissableWith' => 'Cancel this action',
    ]);

    $component
        ->assertSet('dismissable', true)
        ->assertDontSee('Close')
        ->assertSee('Cancel this action');
});

it('can submit the form with custom text', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'form' => SlideOverTestForm::class,
        'submitWith' => 'Confirm awesome stuff',
    ]);

    $component
        ->assertDontSee('Close')
        ->assertSee('Confirm awesome stuff');
});

it('cannot dismiss the form if not allowed', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'form' => SlideOverTestForm::class,
        'dismissable' => false,
    ]);

    $component
        ->assertSet('dismissable', false)
        ->assertDontSee('Close');
});

it('will display the title', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'title' => 'Great slide-over title',
    ]);

    $component
        ->assertSee('Great slide-over title');
});

it('will display the description', function () {
    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'description' => 'This is a sentence to describe the slide-over.',
    ]);

    $component
        ->assertSee('This is a sentence to describe the slide-over.');
});

it('can receive an Eloquent record', function () {
    $user = User::make(['email' => 'john@john.com', 'password' => 'password']);

    UserForm::$expectedUser = $user;

    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
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

    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'slot' => $slot,
    ]);

    $component
        ->assertSet('slot', $slot)
        ->assertSee($html, false);
});

it('form will be prioritised above slot', function () {
    $html = '<p>This is a paragraph</p>';
    $slot = new HtmlString($html);

    $component = Livewire::test(SlideOver::class, [
        'id' => 'test-slide-over',
        'slot' => $slot,
        'form' => UserForm::class,
    ]);

    $component
        ->assertSet('slot', $slot)
        ->assertDontSee($html);
});
