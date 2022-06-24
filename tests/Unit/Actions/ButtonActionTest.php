<?php

use RalphJSmit\Tall\Interactive\Actions\ButtonAction;

it('can determine whether a button action is visible or hidden', function () {
    $action = ButtonAction::make('test')
        ->visible(fn () => true);

    expect($action->isHidden())->toBeFalse();

    $action->hidden(fn () => true);

    expect($action->isHidden())->toBeTrue();
});
