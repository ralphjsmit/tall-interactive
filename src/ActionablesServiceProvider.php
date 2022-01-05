<?php

namespace RalphJSmit\Tall\Interactive;

use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\View\Components\ActionablesManager;
use RalphJSmit\Tall\Interactive\View\Components\Forms\Controls\Classic;
use RalphJSmit\Tall\Interactive\View\Components\Forms\Controls\Minimal;
use RalphJSmit\Tall\Interactive\View\Components\Forms\FormContainer;
use RalphJSmit\Tall\Interactive\View\Components\InlineForm;
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
            ->hasViewComponents('tall-interactive::', Modal::class, SlideOver::class, ActionablesManager::class, InlineForm::class, FormContainer::class, Minimal::class, Classic::class);
    }

    public function bootingPackage(): void
    {
        Livewire::component('tall-interactive::actionables-manager', \RalphJSmit\Tall\Interactive\Livewire\ActionablesManager::class);
        Livewire::component('tall-interactive::modal', \RalphJSmit\Tall\Interactive\Livewire\Modal::class);
        Livewire::component('tall-interactive::slide-over', \RalphJSmit\Tall\Interactive\Livewire\SlideOver::class);
        Livewire::component('tall-interactive::inline-form', \RalphJSmit\Tall\Interactive\Livewire\InlineForm::class);
    }
}
