<?php

namespace RalphJSmit\Tall\Interactive\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormContainer extends Component
{
    public function render(): View
    {
        return view('tall-interactive::components.forms.form-container');
    }
}
