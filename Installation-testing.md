
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

Now, add the following code in a Blade file that is loaded on every page, e.g. in your `layouts/app.blade.php`:
```
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
