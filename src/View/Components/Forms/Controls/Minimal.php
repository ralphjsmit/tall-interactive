<?php

namespace RalphJSmit\Tall\Interactive\View\Components\Forms\Controls;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Minimal extends Component
{
    public function render(): View
    {
        return view('tall-interactive::components.forms.controls.minimal');
    }
}
