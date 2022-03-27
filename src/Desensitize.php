<?php

namespace Waryor\Desensitize;

use Illuminate\Routing\Matching\UriValidator;
use Waryor\Desensitize\Routing\Route;
use Waryor\Desensitize\Validator\DesensitizedUriValidator;

/**
 * Class Desensitize
 * @package Waryor\Desensitize
 */
class Desensitize
{
    /**
     * Initialize the desensitization middleware.
     *
     * @var string $basePath
     */
    public static function initialize(string $basePath = '')
    {
        if(Route::$validators != null)
        {
            Route::$validators = array_filter(Route::$validators, function($validator) {
                return (get_class($validator) != UriValidator::class) && (get_class($validator) != DesensitizedUriValidator::class);
            });
        }
        Route::$validators[] = new DesensitizedUriValidator($basePath);
    }
}