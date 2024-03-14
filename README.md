![tall-interactive](https://github.com/ralphjsmit/tall-interactive/blob/main/docs/images/tall-interactive.jpg)

# Create forms, modals and slide-overs with ease.

This package allows you to create beautiful forms, modals and slide-overs with ease. It utillises the great Filament Forms package for creating the forms and the awesome TALL-stack for the design.

> [!IMPORTANT]  
> This package will only work for Filament V2 and Livewire V2. Since Filament V3, the better way to implement modals and slide-overs is by utilising the new [Filament Actions](https://filamentphp.com/docs/3.x/actions/installation). 


[![Run tests](https://github.com/ralphjsmit/tall-interactive/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/ralphjsmit/tall-interactive/actions/workflows/run-tests.yml)

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

Add the following to the `content` key of your `tailwind.config.js` file:

```js
module.exports = {
    content: [
        './vendor/ralphjsmit/tall-interactive/resources/views/**/*.blade.php',
        // All other locations
    ],
///
```

#### Toast notifications

Using the [Toast TALL notifications package](http://github.com/usernotnull/tall-toasts) is not required, but it is recommended if you need to send notifications to your users, for example on submitting a form.

If you decide to use Toast, please follow their [**setup instructions**](https://github.com/usernotnull/tall-toasts#setup).

#### Tall Interactive

After installing the package and setting up the dependencies, **add the following code to your Blade** files so that it's **loaded on every page**. For example in your `layouts/app.blade.php` view:

```blade
<x-tall-interactive::actionables-manager />
```

**Now you're ready to go and build your first actionables!**

> #### Faster installation
>
> If you want a faster installation process, you could check out my [ralphjsmit/tall-install](https://github.com/ralphjsmit/tall-install) package. This package provides you with a simple command that runs the installation process for all the above dependencies in a plain Laravel installation.
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
> The `tall-install` command also has a few additional options you can use, like installing Pest, Browsersync and DDD. Please [check out the documentation](https://github.com/ralphjsmit/tall-install#installation--usage) for that.

## Usage

You can build a **modal**, a **slide-over** or an **inline form** (together I call them 'actionables') with three things:

- With a **Filament Form**
- With a **Livewire component**
- With **custom Blade contents**

### Creating a Filament Form

To start **building our first actionable**, let's do some preparation first. Create a new file in your `app/Forms` directory (custom namespaces are also fine). You could call it `UserForm` or however you like.

Add the following contents to the file:

```php
<?php

namespace App\Forms;

use RalphJSmit\Tall\Interactive\Forms\Form;

class UserForm extends Form 
{
    public function getFormSchema(): array
    {
        return [];
    }

    public function submit(): void
    {
        //
    }

    public function mount(): void 
    {
        //
    }
    
    /** Only applicable for Modals and SlideOvers */
    public function onOpen(): void 
    {
        //
    }
}
```

### Building your form

**Creating a form with Filament** is very easy. The **field classes** of your form reside in the **`getFormSchema()`** method of the Form class.

> For all the available fields, [check out the Filament documentation](https://filamentadmin.com/docs/2.x/forms/fields).

```php
public function getFormSchema(Component $livewire): array
{
    return [
        TextInput::make('email')
            ->label('Enter your email')
            ->placeholder('john@example.com')
            ->required(),
        Grid::make()->schema([
            TextInput::make('firstname')
                ->label('Enter your first name')
                ->placeholder('John'),
            TextInput::make('lastname')
                ->label('Enter your last name')
                ->placeholder('Doe'),
        ]),
        TextInput::make('password')
            ->label('Choose a password')
            ->password(),
        MarkdownEditor::make('why')
            ->label('Why do you want an account?'),
        Placeholder::make('open_child_modal')
            ->disableLabel()
            ->content(
                new HtmlString('Click <button onclick="Livewire.emit(\'modal:open\', \'create-user-child\')" type="button" class="text-primary-500">here</button> to open a child modal🤩')
            ),
    ];
}
```

#### Default values & models

The field values are stored on the `$data` array property on the `$livewire` component. You can set default values by using the Filament `->default()` method:

```php
public function getFormSchema(Component $livewire): array
{
    return [
        TextInput::make('year')
            ->label('Pick your year of birth')
            ->default(now()->subYears(18)->format('Y'))
            ->required(),
    ];
}
```

You can also add a `fill()` method on your form class. This will be passed to the `$this->form->fill()` method and can be used for pre-filling values:

Here is an example of pre-filling a form based on a Blade component parameter:

```php  
    public int $personId;
    
    public function mount(array $params): void
    {
        $this->personId = $params['personId'];
    }
    
    public function fill(): array
    {
        $person = Person::find($this->personId);
        
        return [
            'year' => $person->birthdate->format('Y'),
        ];
    }
```

#### Submitting a form

You can use the **`submit()` method** to provide the logic for submitting the form.

```php
use Illuminate\Support\Collection;

public function submit(Collection $state): void
{
    User::create($state->all());

    toast()
        ->success('Thanks for submitting the form! (Your data isn\'t stored anywhere.')
        ->push();
}
```

#### Adding custom validation messages

You may register custom validation messages by implementing the `getErrorMessages()` function:

```php
public function getErrorMessages(): array
{
    return [
        'email.required' => 'Please fill in your e-email',
        'age.required' => 'Please enter your age',
        'age.numeric' => 'Your age must be a number',
    ];
}

```

#### Dependency injection in form classes

The `tall-interactive` package also provides **dependency injection** for **all the methods in a form class**, similar to Filament Forms.

You can specify the following variables in each of the above methods:

1. `$livewire` to get the **current Livewire instance**
2. `$model` to get the **current model** (if any)
3. `$formClass` to access the **current instance of the form class**. You could use this to set and get parameters (see [Storing data](#storing-data)).
4. `$formVersion` to access the **current form version**. You could use this to dinstinguish between different versions of your form (like a 'create' and 'edit' version of the same form).
5. `$state` to access the **currently submitted form data**. This is a collection. Only available in the `submit` method.
6. `$close` to get a closure that allows you to **close an actionable**. You may pass the closure a string with the `id` of an actionable in order to close that actionable. It defaults to the current actionable. If you pass an `id` that doesn't exist nothing will happen.
7. `$forceClose` to get a closure that allows you to **close all actionables**.
8. `$params` to get an array with all additional parameters passed to the actionable Blade component.

Using the `$close()` and `$forceClose()` closures are a very **advanced way of customization** which actionables should be open and which actionables not.

You may **mix-and-match** those dependencies however you like and only include those that you need. Similar to [Filament's closure customization](https://filamentadmin.com/docs/2.x/forms/advanced#using-closure-customisation).

For example:

```php
use Closure;
use Livewire\Component;
use App\Models\User;

public function submit(Component $livewire, User $model, Collection $state, Closure $close, Closure $forceClose): void 
{
    $model
        ->fill($state->except('password'))
        ->save();

    if ($state->has('password')) {
        $model->update(
            $state->only('password')->all()
        );
    }
    
    /* Close current actionable */
    $close(); 
    
    /* Close another actionable */
    $close('another-peer-actionable'); 
    
    /* Close all open actionables */
    $forceClose();
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

If you specify the `closeOnSubmit` attribute, the actionable will **automatically close on submit**. This attribute is `true` by default, meaning that the actionable will close after successfully submitting the form.

If you specify the `forceCloseOnSubmit` attribute, **all actionables will be closed** upon successfully submitting this form. This could be handy for situations like this: Edit User > Delete User > Submit. This attribute is `false` by default.

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    closeOnSubmit="false"
/>
```

If you need more advanced customization of which actionables to close and which to keep open, you should innject and use the `$close()` and `$forceClose()` in the `submit()` method in the formclass.

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

### Custom parameters

You may pass any custom parameters to the Blade component, however you like. Those are collected in an array and can be used in your form:

```blade
<x-tall-interactive::modal
    id="create-user"
    :form="\App\Forms\UserForm::class"
    closeOnSubmit
    x="test"
    :y="8*8"
    z
/>
```

```php
public function getFormSchema(array $params): array
{
    // $params
    // [ 'x' => 'test', 'y' => 64, 'z' => true ]
    
    return [
        // ..
    ];
}
```

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

You may specify the `container` attribute to **put an inline form in a nice container**. A container is a simple wrapper that places the form in a white box with a nice shadow.

**Changing the controls design**

You may specify the `controlsDesign` to **change the design of the buttons** at the bottom of the form. It takes on of two values: `minimal` and `classic`. By default it is `minimal`.

## Advanced usage

### Storing data

In some cases it can be handy to store data in the instance of your form class. You can use that data later in the process, for example when submitting the form.

You may add `public` properties on your form class to store data in. A good place to do so could be the `mount()` method, as shown below.

### Mounting the form

You can use the `mount()` method on the form class to mount your form. This can be useful for storing / setting data in the form class when it is invoked for the first time.

You may use all the dependency injection functionality that's available as well (for a list of all the possible parameters, see above):

```php
public User $user;
public string $x = '';

public function mount(array $params, User $model): void
{
    $this->user = $model;
    $this->x = $params['x'];
}
                                                                  
public function getFormSchema(): array
{
    return [
        Hidden::make('user_id')->default($this->user->id)
    ];
}
```

### Reacting to events

You may add an `onOpen()` method to your form class to react to the event of opening of the actionable. As you might expect, this method is only available for modals and slide-overs.

```php
public function onOpen(): void
{
    // ...
}
```

You may also pass parameters to the events when opening a form:

```blade
<button onclick="Livewire.emit('modal:open', 'create-user', 8, 'admin')" type="button" class="...">
    Open Modal
</button>
```

Use the `$eventParams` variable to access the parameters passed to the event.

```php
public User $user;
public array $prefilledValues = [];

public function onOpen(array $eventParams, self $formClass): void
{
    $formClass->user = User::find($eventParams[0]);
    $formClass->prefilledValues['type'] = $eventParams[1];
}
```

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
