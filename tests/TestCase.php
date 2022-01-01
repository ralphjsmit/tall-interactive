<?php

namespace RalphJSmit\Tall\Interactive\Tests;

use Filament\Forms\FormsServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RalphJSmit\Tall\Interactive\ActionablesServiceProvider;
use RyanChandler\TablerIcons\BladeTablerIconsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ActionablesServiceProvider::class,
            LivewireServiceProvider::class,
            BladeTablerIconsServiceProvider::class,
            FormsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        //        config()->set('database.default', 'testing');
        /*
        $migration = include __DIR__.'/../database/migrations/create_tall-interactive_table.php.stub';
        $migration->up();
        */
    }
}
