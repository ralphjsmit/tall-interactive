# Create forms, modals and slide-overs with ease.

This package allows you to create beautiful forms, modals and slide-overs with ease. It utillises the great Filament Forms package for creating the forms and the awesome TALL-stack for the design.


**[Installation instructions for testing](https://github.com/ralphjsmit/tall-interactive/blob/main/Installation-testing.md)**


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

You can install them manually or skip to the [Faster installation section](#faster-installation) for new projects.

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

Finally, add the following to the `content` key of your `tailwind.config.js` file:

```js
module.exports = {
    content: [
        './vendor/ralphjsmit/tall-interactive/resources/views/**/*.blade.php',
        // All other locations
    ],
///
```

Now you're ready to go!

#### Faster installation

If you want a faster installation process, you could check out my [ralphjsmit/tall-install](https://github.com/tall-install) package. This package provides you with a simple command that runs the installation process for all the above dependencies in a plain Laravel installation. 

It works like this:

```bash
# First, create a new plain Laravel installation, for example with:

laravel new name 
# OR: composer create-project laravel/laravel name 

# Next, require the `tall-install` package and run the `php artisan tall-install` command:
composer require ralphjsmit/tall-install
composer dump-autoload
php artisan tall-install
```

The `tall-install` command also has a few additional options you can use, like installing Pest, Browsersync and DDD. Please check out the [documentation](https://github.com/ralphjsmit/tall-install#installation--usage) for that.

Now, you are ready to install the `tall-interactive` package: 

```bash
composer require ralphjsmit/tall-interactive
```

To setup the `tall-interactive` package, add the following to your `layouts/app.blade.php` file:

```blade
<x-tall-interactive::actionables-manager />
```

And add the files to your `tailwind.config.js` file:

```js
module.exports = {
    content: [
        './vendor/ralphjsmit/tall-interactive/resources/views/**/*.blade.php',
        // All other locations
    ],
///
```

Now you're ready to go and build your first forms!

## Usage

You can build a modal, a slide-over or an inline form (I call them 'actionables') with three things:

- With a Filament Form 
- With a Livewire component (will be implemented soon)
- With custom Blade contents


### Creating a Filament Form

To start building your first form, create a new file in your `app/Forms` directory (custom namespaces also allowed). You could call it `UserForm` or however you like.

Run the following command to generate a form in your `app/Forms` namespace:

```bash
php artisan make:form UserForm
```

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

### Building your form

Creating a form with Filament is very easy. The field classes of your form reside in the static `getFormSchema()` method of the Form class.

For all the available fields, [check out the Filament documentation](https://filamentadmin.com/docs/2.x/forms/fields).

```php
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
```

Use the static `getFormDefaults()` to specify the default values for each field as `$field => $defaultValue`. This will add the required public properties on the right Livewire component.

```php
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
```

#### Binding to model properties

If you want to bind directly to model properties, you should use the `$recordPathIfGiven` variable to prefix your fields.

This makes sure that whenever you provide a model to the actionable, your fields will be prefixed with the correct location. If you haven't a provided a model, this variable will be an empty string.

```php
public static function getFormSchema(string $recordPathIfGiven): array
{
    return [
        TextInput::make("{$recordPathIfGiven}email")->label('Enter your email')->placeholder('john@example.com')->required(),
        Grid::make()->schema([
            TextInput::make("{$recordPathIfGiven}firstname")->label('Enter your first name')->placeholder('John'),
            TextInput::make("{$recordPathIfGiven}lastname")->label('Enter your last name')->placeholder('Doe'),
        ]),
    ];
}
```


> **NB.:** You are required to provide a default value for each field, otherwise Livewire will throw a "property not found" error.

#### Submitting a form

You can use the static `submitForm()` method to provide the logic for submitting the form. 

```php
public static function submitForm(array $formData)
{
    User::create($formData);


    toast()
        ->success('Thanks for submitting the form! (Your data isn\'t stored anywhere.')
        ->push();
}
```

#### Dependency injection in form classes

The `tall-interactive` package also provides dependency injection for all the methods in a form class, similar to Filament Forms.

You can specify the following variables in each of the above methods:

1. `\Livewire\Component $livewire` to access the current Livewire instance
2. `$record` to access the record (if any)
3. `$recordPathIfGiven` to access the current path to the record (if any)

For example:

```php
use Livewire\Component;
use App\Models\User;

public static function submitForm(Component $livewire, array $formData, User $record) 
{
    // Save the user
    $record->save();

    if ($formData['password]) {
        $record->update([
            'password' => $formData['password'],
        ]);
    }

    //
}
```

### Using Modals and Slide-Overs

In order to open a modal on a page, include the following somewhere on the page:

```blade
<x-tall-interactive::modal id="create-user" />
```

If you want to use a slide-over instead of a modal, use the following tag:

```blade
<x-tall-interactive::slide-over id="create-user" />
```

Both the `modal` component and the `slide-over` component work exactly the same. 

The only required parameter here is the `id` of a modal. This `id` is required, because you need it when emitting a Livewire event to open the modal. The `id` for a modal should be different for each modal on a page, otherwise multiple modals would open at the same time.

You can open the modal by dispatching a `modal:open` event with the `id` as it's first parameter:
```blade
<button onclick="Livewire.emit('modal:open', 'create-user')" type="button" class="...">
    Example Modal
</button>
```

#### Filament Forms

Currently the modal is empty. Let's fix that by displaying our form. In order to display a form, add the `form` property:

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
/>
```

Now, when you emit the `modal:open` event, the modal will contain a nice form.

#### Livewire 

You may specify the name of a Livewire component to be used instead of a form, by using the `livewire` attribute:

```blade
<x-tall-interactive::modal
    id="create-user"
    livewire="users.edit"
/>
```

If you specify both the `form` and the `livewire` attribute, only the `form` will be displayed.

#### Blade

You can also give custom Blade content to an actionable by putting in the slot of component:

```
<x-tall-interactive::modal id="create-user">

    <p>My custom Blade content in this actionable!<p>

</tall-interactive::modal>
```

#### Configuration attributes

The following attributes for configuring your actionable available.

**Closing a modal on successfully submitting the form**

If you specify the `closeOnSubmit` attribute, the actionable will automatically close on submit. This attribute is `false` by default.

If you specify the `forceCloseOnSubmit` attribute, all modals and slide-overs will be closed upon successfully submitting this form. This could be handy for situations like this: Edit User > Delete User > Submit. This attribute is `false` by default.
```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    closeOnSubmit
/>
```

**Adding a title**

You may specify the title of a form with the `title` attribute. If you omit the `title` attribute, the title will not be visible.
```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    title="Create a user"
/>
```

**Adding a description**

You may specify the description of a form with the `description` attribute. If you omit the `description` attribute, the description will not be visible.

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    title="Create a user"
    description="Use this form to grant a user access to your system."
/>
```

**Text on submit button**

You may set the text on the submit-button by specifiying the `submitWith` attribute:

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    submitWith="Create user"
/>
```

**Closing a form before submitting**

You may allow an actionable to be dismissed (closed) before it is submitted by specifiying the `dismissable` attribute. By default this is disabled.

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    dismissable
/>
```

You may specify the text on the close-button of an actionable with the `dismissableWith` attribute. By default the text will be 'Close'.

If you specify the `dismissableWith` attribute, you are allowed to omit the `dismissable` attribute:

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    dismissableWith="Go back"
/>
```

**Hiding the buttons**

You may hide the buttons at the bottom of an actionable by specifiying the `hideControls` attribute:

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    hideControls
/>
```

**Setting a maximum width**

You may set the width of the actionable by specify the `maxWidth` attribute. Possible values are: `sm`,`md`,`lg`,`xl`,`2xl`, `3xl`, `4xl`, `5xl`, `6xl`, `7xl`.

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    maxWidth="2xl"
/>
```

**Model binding**

You may give the form an (Eloquent) model, which can be used for things like Edit forms:

```blade
@foreach (\App\Models\User::get() as $user)
    <x-tall-interactive::modal
        id="edit-user"
        :form="\App\Forms\UserForm::class"
        :model="$user"
    />
@endforeach
```


## Inline forms

You may also display inline forms on a page like this:

```blade
<x-tall-interactive::inline-form />
```

For an inline form, you don't to specify an `id`.

An inline form takes the following parameters:

1. `container`
2. `controlsDesign`
3. `form`
4. `title`
5. `description`
6. `submitWith`
7. `hideControls`
8. `maxWidth`
9. `model`

Parameters 3-9 work the same as explained above, so I'm not going to repeat them here.

**Putting an inline form in a container**

You may specify the `container` attribute to put an inline form in a container. A container is just a simple wrapper that looks like this:

// Image

**Changing the controls design**

You may specify the `controlsDesign` to change the design of the buttons at the bottom of the form. It takes on of two values: `minimal` and `classic`. By default it is `minimal`.

## General

Optionally, you can publish the views using (not recommended, they can get outdated):

```bash
php artisan vendor:publish --tag="tall-interactive-views"
```

