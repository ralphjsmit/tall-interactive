<?php

namespace RalphJSmit\Tall\Interactive\Livewire;

use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

abstract class Actionable extends Component
{
    use WireToast;

    protected $listeners = [];
}
