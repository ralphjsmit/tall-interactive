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

### Setup

The package requires the following dependencies:

- Laravel Livewire
- Alpine.js
- Tailwind CSS
- Filament Forms
- Toast notification (not required, but very handy)

#### Laravel Livewire

Please follow the [Laravel Livewire installation instructions](https://laravel-livewire.com/docs/2.x/alpine-js#installation) if you haven't done so yet.

#### Alpine.js, Tailwind, Filament Forms

Please follow the [Filament Forms installation instructions](https://filamentadmin.com/docs/2.x/forms/installation) to install Alpine.js, Tailwind CSS and Filament Forms.

#### Toast notifications

Using the [Toast TALL notifications package](http://github.com/usernotnull/tall-toasts) is not required, but it is a recommend if you need to send notifications to your users, for example on submitting a form.

If you decide to use Toast, please follow their [setup instructions](https://github.com/usernotnull/tall-toasts#setup).

#### Tall Interactive

After installing the package and setting up the dependencies, add the following code to your Blade files so that it's loaded on every page. For example in your `layouts/app.blade.php` view:

```blade
<x-tall-interactive::actionables-manager />
```

Now you're ready to go!

#### Faster installation

If you want a faster installation process, you could check out my [ralphjsmit/tall-install](https://github.com/tall-install) package. This package provides you with a simple command that all the above dependencies in a plain Laravel installation. 

It works like this:

```bash
# First, create a new plain Laravel installation, for example with:
laravel new name # OR: composer create-project laravel/laravel name 

# Next, require the `tall-install` package and run the `php artisan tall-install` command:
composer require ralphjsmit/tall-install
composer dump-autoload
php artisan tall-install
```

The `tall-install` command also has a few additional options you can use, like installing Pest, Browsersync and DDD. Please check out the [documentation](https://github.com/ralphjsmit/tall-install#installation--usage) for that.

Now, you can install the `tall-interactive` package: 

```bash
composer require ralphjsmit/tall-interactive
```

Finally, add the following to your `layouts/app.blade.php` file or an other file that is loaded on every page:

```blade
<x-tall-interactive::actionables-manager />
```

Now you're ready to go and build your first forms!

## Usage

You can build a modal, a slide-over or an inline form (I call them 'actionables') with three things:

- With a Filament Form 
- With a Livewire component (will be implemented soon)
- With custom Blade contents

### Creating a Filament Form

To start building your first form, create a new file in your `app/Forms` directory (custom namesapces also allowed). You could call it `UserForm` or however you like.

Add the following contents to the form file:

```php
<?php

namespace App\Forms;

use RalphJSmit\Tall\Interactive\Forms\Form;

class UserForm extends Form {

    public static function getFormSchema(): array
    {
        return [];
    }

    public static function getFormDefaults(): array
    {
        return [];
    }

    public static function submitForm()
    {
        //
    }

    public static function initialize() {}
}
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



### Customizing the views

Optionally, you can publish the views using (not recommended, they can get outdated):

```bash
php artisan vendor:publish --tag="tall-interactive-views"
```

