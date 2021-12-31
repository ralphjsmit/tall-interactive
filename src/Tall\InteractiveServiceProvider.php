<?php

namespace RalphJSmit\Tall\Interactive;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use RalphJSmit\Tall\Interactive\Commands\Tall\InteractiveCommand;

class Tall\InteractiveServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('tall-interactive')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_tall-interactive_table')
            ->hasCommand(Tall\InteractiveCommand::class);
    }
}
