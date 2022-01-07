<?php

use Livewire\Component;
use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\Livewire\Modal;

beforeEach(function () {
    Livewire::component('test-livewire-component', TestLivewireComponent::class);
});

it('can render a Livewire component', function (string $livewire, string $componentInputName) {
    $component = Livewire::test($livewire, [
        'id' => 'test-actionable',
        'livewire' => $componentInputName,
    ]);

    $component
        ->assertSee('Hey there!');
})->with('actionables')->with([
    'test-livewire-component',
    TestLivewireComponent::class,
]);

it('form will be prioritised above Livewire', function (string $livewire, string $componentInputName) {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => UserForm::class,
        'livewire' => $componentInputName,
    ]);

    $component
        ->assertSet('livewire', $componentInputName)
        ->assertDontSee('Hey there!');
})->with('actionables')->with([
    'test-livewire-component',
    TestLivewireComponent::class,
]);

class TestLivewireComponent extends Component
{
    public function render()
    {
        return '<div>Hey there!</div>';
    }
}
