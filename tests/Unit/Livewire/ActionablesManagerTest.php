<?php

use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\Livewire\ActionablesManager;

it('can record stacktrace of opened modals and slideovers', function () {
    $component = Livewire::test(ActionablesManager::class);

    $component
        ->emit('modal:open', 'modal-1')
        ->assertSet('openedActionables', ['modal-1',])
        ->assertEmitted('actionable:open', 'modal-1');

    $component
        ->emit('slideOver:open', 'slideover-1')
        ->assertSet('openedActionables', [
            'modal-1',
            'slideover-1',
        ])
        ->assertEmitted('actionable:close', 'modal-1')
        ->assertEmitted('actionable:open', 'slideover-1');

    $component
        ->emit('slideOver:close')
        ->assertSet('openedActionables', [
            'modal-1',
        ])
        ->assertEmitted('actionable:close', 'slideover-1')
        ->assertEmitted('actionable:open', 'modal-1');

    $component
        ->emit('modal:close')
        ->assertSet('openedActionables', [])
        ->assertEmitted('actionable:close', 'modal-1');

    $component
        ->emit('slideOver:open', 'slideover-2')
        ->assertSet('openedActionables', [
            'slideover-2',
        ])
        ->assertEmitted('actionable:open', 'slideover-2')
        ->emit('slideOver:close')
        ->assertSet('openedActionables', [])
        ->assertEmitted('actionable:close', 'slideover-2');
});

it('can force-close opened modals and slideovers', function () {
    $component = Livewire::test(ActionablesManager::class);

    $component
        ->emit('modal:open', 'modal-1')
        ->emit('slideOver:open', 'slide-over-2')
        ->assertSet('openedActionables', ['modal-1', 'slide-over-2']);

    $component
        ->emit('actionables:forceClose')
        ->assertEmitted('actionable:close', 'modal-1')
        ->assertEmitted('actionable:close', 'slide-over-2')
        ->assertSet('openedActionables', []);
});
