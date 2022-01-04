<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use RalphJSmit\Tall\Interactive\Tests\TestCase;

require __DIR__ . '/Fixtures/TestClasses.php';

uses(
    TestCase::class,
    LazilyRefreshDatabase::class,
)->in(__DIR__);
