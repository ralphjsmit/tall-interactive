![tall-interactive](https://github.com/ralphjsmit/tall-interactive/blob/7e83eff29dae09f6f8bc22437ad19763a403b0db/docs/images/tall-interactive.jpg)


# Create forms, modals and slide-overs with ease.

This package allows you to create beautiful forms, modals and slide-overs with ease. It utillises the great Filament Forms package for creating the forms and the awesome TALL-stack for the design.

**[Installation instructions for testing](https://github.com/ralphjsmit/tall-interactive/blob/main/Installation-testing.md)**

[![run-tests](https://github.com/ralphjsmit/tall-interactive/actions/workflows/run-tests.yml/badge.svg?event=push)](https://github.com/ralphjsmit/tall-interactive/actions/workflows/run-tests.yml)

## Installation

You can install the package via composer:

```bash
composer require ralphjsmit/tall-interactive
```

### Setup

The package requires the **following dependencies**:

- Laravel Livewire
- Alpine.js
- Tailwind CSS
- Filament Forms
- Toast notification (not required, but very handy)

You can install them **manually** or skip to the [**Faster installation section**](#faster-installation) for new projects.

#### Laravel Livewire

Please follow the [**Laravel Livewire installation instructions**](https://laravel-livewire.com/docs/2.x/alpine-js#installation) if you haven't done so yet.

#### Alpine.js, Tailwind, Filament Forms

Please follow the [**Filament Forms installation instructions**](https://filamentadmin.com/docs/2.x/forms/installation) to install Alpine.js, Tailwind CSS and Filament Forms.

Add the following to the `content` key of your `**tailwind.config.js**` file:

```js
module.exports = {
    content: [
        './vendor/ralphjsmit/tall-interactive/resources/views/**/*.blade.php',
        // All other locations
    ],
///
```

#### Toast notifications

Using the [Toast TALL notifications package](http://github.com/usernotnull/tall-toasts) is not required, but it is a recommend if you need to send notifications to your users, for example on submitting a form.

If you decide to use Toast, please follow their [**setup instructions**](https://github.com/usernotnull/tall-toasts#setup).

#### Tall Interactive

After installing the package and setting up the dependencies, **add the following code to your Blade** files so that it's **loaded on every page**. For example in your `layouts/app.blade.php` view:

```blade
<x-tall-interactive::actionables-manager />
```

**Now you're ready to go and build your first actionables!**

> #### Faster installation
> 
> If you want a faster installation process, you could check out my [ralphjsmit/tall-install](https://github.com/tall-install) package. This package provides you with a simple command that runs the installation process for all the above dependencies in a plain Laravel installation. 
>
> It works like this:
> 
> ```bash
> # First, create a new plain Laravel installation, for example with:
> 
> laravel new name 
> # OR: composer create-project laravel/laravel name 
> 
> # Next, require the `tall-install` package and run the `php artisan tall-install` command:
> composer require ralphjsmit/tall-install
> composer dump-autoload
> php artisan tall-install
> ```
> 
> The `tall-install` command also has a few additional options you can use, like installing Pest, Browsersync and DDD. Please check out the [documentation]> (https://github.com/ralphjsmit/tall-install#installation--usage) for that.

## Usage

You can build a **modal**, a **slide-over** or an **inline form** (together I call them 'actionables') with three things:

- With a **Filament Form** 
- With a **Livewire component** (will be implemented soon)
- With **custom Blade contents**


### Creating a Filament Form

To start **building our first actionable**, let's do some preparation first. Create a new file in your `app/Forms` directory (custom namespaces are also fine). You could call it `UserForm` or however you like.

Run the following command to **generate a Filament form class** in your `app/Forms` namespace:

```bash
php artisan make:form UserForm
```

This will add the following contents to the form file:

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

**Creating a form with Filament** is very easy. The **field classes** of your form reside in the static `**getFormSchema()**` method of the Form class.

> For all the available fields, [check out the Filament documentation](https://filamentadmin.com/docs/2.x/forms/fields).

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

Use the **static `getFormDefaults()` to specify the default values** for each field as `$field => $defaultValue`. This will add the required public properties on the right Livewire component.

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

If you want to **bind directly to model properties**, you should use the **`$modelPathIfGiven`** variable to prefix your fields.

This makes sure that **whenever you provide a model** to the actionable, your fields will be **prefixed with the correct location**. If you haven't a provided a model, this variable will be an empty string.

```php
public static function getFormSchema(string $modelPathIfGiven): array
{
    return [
        TextInput::make("{$modelPathIfGiven}email")->label('Enter your email')->placeholder('john@example.com')->required(),
        Grid::make()->schema([
            TextInput::make("{$modelPathIfGiven}firstname")->label('Enter your first name')->placeholder('John'),
            TextInput::make("{$modelPathIfGiven}lastname")->label('Enter your last name')->placeholder('Doe'),
        ]),
    ];
}
```

> **NB.:** You are required to provide a default value for each field, otherwise Livewire will throw a "property not found" error.

#### Submitting a form

You can use the **static `submitForm()` method** to provide the logic for submitting the form. 

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

The `tall-interactive` package also provides **dependency injection** for **all the methods in a form class**, similar to Filament Forms.

You can specify the following variables in each of the above methods:

1. `$livewire` to get the **current Livewire instance**
2. `$model` to get the **current model** (if any)
3. `$modelPathIfGiven` to access the **current path to the model** (if any) (see [Binding to model properties](#binding-to-model-properties)).
4. `$formVersion` to access the **current form version**. You could use this to dinstinguish between different versions of your form (like a 'create' and 'edit' version of the same form).
5. `$formData` to access the **current form data**. Only available in the `submitForm` method.
6. `$close` to get a closure that allows you to **close an actionable**. You may pass the closure a string with the `id` of an actionable in order to close that actionable. It defaults to the current actionable. If you pass an `id` that doesn't exist nothing will happen. 
7. `$forceClose` to get a closure that allows you to **close all actionables**. 

Using the `$close()` and `$forceClose()` closures are a very **advanced way of customization** which actionables should be open and which actionables not. 

You may **mix-and-match** those dependencies however you like and only include those that you need. Similar to [Filament's closure customization](https://filamentadmin.com/docs/2.x/forms/advanced#using-closure-customisation).

For example:

```php
use Closure;
use Livewire\Component;
use App\Models\User;

public static function submitForm(Component $livewire, User $model, array $formData, Closure $close, Closure $forceClose) 
{
    // Save the user
    $model->save();

    if ($formData['password]) {
        $model->update([
            'password' => $formData['password'],
        ]);
    }
    
    /* Close current actionable */
    $close(); 
    
    /* Close another actionable */
    $close('another-peer-actionable'); 
    
    /* Close all open actionables */
    $forceClose();
    

    //
}
```

### Using Modals and Slide-Overs

In order to **open a modal on a page**, include the following somewhere on the page:

```blade
<x-tall-interactive::modal id="create-user" />
```

If you want to **open a slide-over** instead of a modal, use the following tag:

```blade
<x-tall-interactive::slide-over id="create-user" />
```

Both the `modal` component and the `slide-over` component work exactly the same. 

The only **required parameter** here is the `id` of an actionable. This `id` is required, because you need it when emitting a Livewire event to open the actionable. The `id` for an actionable should be different for each actionable on a page, otherwise multiple actionables would open at the same time.

You can **open an actionable** by dispatching a `modal:open` or `slideOver:open` event with the `id` as it's first parameter:

```blade
<button onclick="Livewire.emit('modal:open', 'create-user')" type="button" class="...">
    Open Modal
</button>
```

You can **close an actionable** by dispatching a `modal:close` or `slideOver:close` event with the `id` as it's first parameter:

```blade
<button onclick="Livewire.emit('modal:close', 'create-user')" type="button" class="...">
    Close modal
</button>
```

You can **close an actionable** without knowing its type by dispatching a `:close` event with the `id` as it's first parameter:

```blade
<button onclick="Livewire.emit(':close', 'create-user')" type="button" class="...">
    Close modal
</button>
```

For all the below examples you can always change `modal` for `slide-over` to use a slide-over instead.

#### Filament Forms

Currently the actionable is empty. Let's fix that by **displaying our form**. In order to display a form, add the `form` property:

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
/>
```

Now, when you **emit the `modal:open` event**, the modal will **contain a nice form**.

#### Livewire 

You may **specify the name of a Livewire component** to be used instead of a form, by using the `livewire` attribute:

```blade
<x-tall-interactive::modal
    id="create-user"
    livewire="users.edit"
/>
```

If you specify both the `form` and the `livewire` attribute, only the `form` will be displayed.

#### Blade

You can also give custom Blade content to an actionable by putting in the slot of component:

```blade
<x-tall-interactive::modal id="create-user">

    <p>My custom Blade content in this actionable!<p>

</tall-interactive::modal>
```

It is recommended not to make the Blade content too big. A few paragraphs is fine, but displaying a 10,000-word article will probably cause significant lag.

#### Configuration attributes

The following **attributes** are available for **configuring your actionable**.

**Closing a modal on successfully submitting the form**

If you specify the `closeOnSubmit` attribute, the actionable will **automatically close on submit**. This attribute is `false` by default, meaning that the actionable will stay open after successfully submitting the form.

If you specify the `forceCloseOnSubmit` attribute, **all actionables will be closed** upon successfully submitting this form. This could be handy for situations like this: Edit User > Delete User > Submit. This attribute is `false` by default. 

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    closeOnSubmit
/>
```

If you need more advanced customization of which actionables to close and which to keep open, you should innject and use the `$close()` and `$forceClose()` in the `submitForm()` method in the formclass. 

**Adding a title**

You may specify the **title of a form** with the `title` attribute. If you omit the `title` attribute, the title will not be visible.

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    title="Create a user"
/>
```

**Adding a description**

You may specify the **description of a form** with the `description` attribute. If you omit the `description` attribute, the description will not be visible.

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    title="Create a user"
    description="Use this form to grant a user access to your system."
/>
```

**Text on submit button**

You may set the **text on the submit-button** by specifiying the `submitWith` attribute:

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    submitWith="Create user"
/>
```

**Closing a form before submitting**

You may **allow an actionable to be dismissed (closed)** before it is submitted by specifiying the `dismissable` attribute. By default this is disabled.

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    dismissable
/>
```

You may **specify the text on the close-button** of an actionable with the `dismissableWith` attribute. By default the text will be 'Close'.

If you specify the `dismissableWith` attribute, you are allowed to omit the `dismissable` attribute:

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    dismissableWith="Go back"
/>
```

**Hiding the buttons**

You may **hide the buttons at the bottom** of an actionable by specifiying the `hideControls` attribute:

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    hideControls
/>
```

**Setting a maximum width**

You may **set the maximum width of an actionable** by specify the `maxWidth` attribute. Allowed values are: `sm`,`md`,`lg`,`xl`,`2xl`, `3xl`, `4xl`, `5xl`, `6xl`, `7xl`.

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    maxWidth="2xl"
/>
```

**Model binding**

You may **give the form an (Eloquent) model**, which can be used for things like edit forms:

```blade
@foreach (\App\Models\User::get() as $user)
    <x-tall-interactive::modal
        id="edit-user"
        :form="\App\Forms\UserForm::class"
        :model="$user"
    />
@endforeach
```

Check out the [section about binding to model properties for this](#binding-to-model-properties).


## Inline forms

You may also **display inline forms** on a page like this:

```blade
<x-tall-interactive::inline-form />
```

For an inline form, you **don't need to specify an `id`**.

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

You may specify the `container` attribute to **put an inline form in a nice container**. A container is just a simple wrapper that looks like this:

// Image

**Changing the controls design**

You may specify the `controlsDesign` to **change the design of the buttons** at the bottom of the form. It takes on of two values: `minimal` and `classic`. By default it is `minimal`.

## Customizing the views

Optionally, you can publish the views using (not recommended, they can get outdated):

```bash
php artisan vendor:publish --tag="tall-interactive-views"
```

## General

🐞 If you spot a bug, please submit a detailed issue and I'll try to fix it as soon as possible.

🔐 If you discover a vulnerability, please review [our security policy](../../security/policy).

🙌 If you want to contribute, please submit a pull request. All PRs will be fully credited. If you're unsure whether I'd accept your idea, feel free to contact me!

🙋‍♂️ [Ralph J. Smit](https://ralphjsmit.com)
