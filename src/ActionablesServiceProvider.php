<?php

namespace RalphJSmit\Tall\Interactive;

use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\View\Components\ActionablesManager;
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
            ->hasViewComponents('tall-interactive::', Modal::class, SlideOver::class, ActionablesManager::class);
    }

    public function bootingPackage(): void
    {
        Livewire::component('tall-interactive::actionables-manager', \RalphJSmit\Tall\Interactive\Livewire\ActionablesManager::class);
        Livewire::component('tall-interactive::modal', \RalphJSmit\Tall\Interactive\Livewire\Modal::class);
    }
}
