<?php

namespace RalphJSmit\Tall\Interactive\Tests;

use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RalphJSmit\Tall\Interactive\ActionablesServiceProvider;

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
