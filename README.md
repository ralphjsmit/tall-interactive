# Create forms, modals and slide-overs with ease.

This package allows you to create beautiful forms, modals and slide-overs with ease. It utillises the great Filament Forms package for creating the forms and the awesome TALL-stack for the design.

## Installation for local testing 

The fastest way to get this up-and-running-locally is to create a new plain Laravel installation, for example:

```bash
laravel new ...
```

For the package to work, you should have Livewire, Tailwind, AlpineJS and Filament Forms installed. I also created a package with an artisan command to install all that for your:

```bash
composer require ralphjsmit/tall-install
composer dump-autoload
php artisan tall-install
```

If you're testing it on an existing project, you should install the dependencies manually.

Next, you need to install the package. Add this to your `composer.json` file to test it locally:
```json
    "repositories": [
        {
            "type": "path",
            "url": "ADD PATH HERE"
        }
    ]
```

And require it like this:
```json
"ralphjsmit/tall-interactive": "@dev",
```

Next, run `composer install` to pull in the package.

Finally, add the following code in a Blade file that is loaded on every page, e.g. in your `layouts/app.blade.php`:
```
<x-tall-interactive::actionables-manager />
```


## Installation

You can install the package via composer:

```bash
composer require ralphjsmit/tall-interactive
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="tall-interactive-views"
```




## Example form component:

```php
<?php

namespace App\Forms;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use RalphJSmit\Tall\Interactive\Forms\Form;

class UserForm extends Form
{
    public static function getFormSchema(Component $livewire): array
    {
        return [
            TextInput::make('email')->label('Enter your email')->placeholder('john@example.com')->required(),
            Grid::make()->schema([
                TextInput::make('firstname')->label('Enter your first name')->placeholder('John'),
                TextInput::make('lastname')->label('Enter your last name')->placeholder('Doe'),
            ]),
            TextInput::make('password')->label('Choose a password')->password(),
            MarkdownEditor::make('why')->label('Why do you want an account?'),
            Placeholder::make('')->content(
                new HtmlString('Click <button onclick="Livewire.emit(\'modal:open\', \'create-user-child\')" type="button" class="text-primary-500">here</button> to open a child modal🤩')
            ),
        ];
    }

    public static function getFormDefaults(): array
    {
        return [
            'email' => null,
            'firstname' => null,
            'lastname' => null,
            'password' => null,
            'why' => null,
        ];
    }

    public static function submitForm()
    {
        toast()
            ->success('Thanks for submitting the form! (Your data isn\'t stored anywhere.')
            ->push();
    }

    public static function initialize() {}
}
```


