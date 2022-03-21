<?php

namespace Waryor\Desensitize\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Desensitize
 * @package Waryor\Desensitize
 */
class Desensitize extends Facade
{
    /**
     * Return the facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'desensitize';
    }
}