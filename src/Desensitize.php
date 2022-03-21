<?php

namespace Waryor\Desensitize;

use Illuminate\Routing\Route;
use Illuminate\Routing\Matching\UriValidator;
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
        $validators = Route::getValidators();
        $validators[] = new DesensitizedUriValidator($basePath);
        Route::$validators = array_filter($validators, function($validator) {
            return get_class($validator) != UriValidator::class;
        });
    }
}