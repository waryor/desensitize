<?php

namespace Waryor\Desensitize\Routing;

use Waryor\Desensitize\Validator\DesensitizedUriValidator;

class RouteParameterBinder extends \Illuminate\Routing\RouteParameterBinder
{
    /**
     * Get the parameter matches for the path portion of the URI.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function bindPathParameters($request)
    {
        $validator = $this->route->getUriValidator();
        $validator->matches($this->route, $request, $matches);
        return $this->matchToKeys(array_slice($matches, 1));
    }

    /**
     * The route instance.
     *
     * @var Route
     */
    protected $route;
}