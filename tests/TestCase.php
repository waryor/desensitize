<?php

namespace Waryor\Desensitize\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Waryor\Desensitize\Desensitize;

class TestCase extends BaseTestCase
{
    public function setUpDesensitized($basePath = '')
    {
        Desensitize::initialize($basePath);
    }
}