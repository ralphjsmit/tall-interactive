<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

trait CanBeDismissed
{
    use RegisterListeners;

    public bool $dismissable = false;
    public string $dismissableWith = 'Close';

    public function mountCanBeDismissed(?bool $dismissable = null, string $dismissableWith = ''): void
    {
        if ( $dismissableWith && $dismissable === null ) {
            $this->dismissable = true;
        }
    }
}
