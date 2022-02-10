<?php

namespace RalphJSmit\Tall\Interactive\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public function render(): View
    {
        return view('tall-interactive::components.modal');
    }
}
