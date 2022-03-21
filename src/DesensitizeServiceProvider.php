<?php

namespace Waryor\Desensitize;

use Illuminate\Support\ServiceProvider;

/**
 * Class DesensitizeServiceProvider
 * @package Waryor\Desensitize
 */
class DesensitizeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('desensitize', function () {
            return new Desensitize();
        });

        $this->app->alias('desensitize', Desensitize::class);
    }
}