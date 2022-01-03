<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use RalphJSmit\Tall\Interactive\Tests\TestCase;

uses(TestCase::class, LazilyRefreshDatabase::class)
    ->in(__DIR__);
