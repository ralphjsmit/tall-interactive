<?php

namespace RalphJSmit\Tall\Interactive;

use RalphJSmit\Tall\Interactive\View\Components\Modal;
use RalphJSmit\Tall\Interactive\View\Components\SlideOver;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ActionablesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('tall-interactive')
            ->hasConfigFile()
            ->hasViews()
            ->hasViewComponents('tall-interactive', Modal::class, SlideOver::classn);
    }
}
