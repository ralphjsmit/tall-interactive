<?php

namespace RalphJSmit\Tall\Interactive\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InlineForm extends Component
{
    public function render(): View
    {
        return view('tall-interactive::components.inline-form');
    }
}
