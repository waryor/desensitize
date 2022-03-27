<?php

namespace Waryor\Desensitize\Routing;

class RoutingServiceProvider extends \Illuminate\Routing\RoutingServiceProvider
{
    /**
     * Register the router instance.
     *
     * @return void
     */
    protected function registerRouter()
    {
        $this->app->singleton('router', function ($app) {
            return new Router($app['events'], $app);
        });
    }
}