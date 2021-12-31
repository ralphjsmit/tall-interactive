<?php

namespace RalphJSmit\Tall\Interactive;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ActionablesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('tall-interactive')
            ->hasConfigFile()
            ->hasViews();
    }
}
