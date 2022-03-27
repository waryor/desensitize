<?php

namespace Waryor\Desensitize\Tests;

use Illuminate\Routing\Matching\UriValidator;
use Illuminate\Routing\Route;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Waryor\Desensitize\Validator\DesensitizedUriValidator;

class TestCase extends BaseTestCase
{
    public function setUpDesensitized($basePath = '')
    {
        $validators = Route::getValidators();
        //Remove UriValidator
        Route::$validators = array_filter($validators, function($validator) {
            return get_class($validator) != UriValidator::class;
        });
        $validator = new DesensitizedUriValidator($basePath);
        if(!in_array($validator, Route::$validators, false)){
            Route::$validators[] = $validator;
        }
    }
}