<?php

namespace RalphJSmit\Tall\Interactive\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RalphJSmit\Tall\Interactive\Tall\Interactive
 */
class Tall\Interactive extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tall-interactive';
    }
}
