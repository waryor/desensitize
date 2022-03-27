<?php

namespace Waryor\Desensitize\Routing;

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
        $path = '/'.ltrim($request->decodedPath(), '/');

        preg_match(preg_replace('/$/','i', $this->route->compiled->getRegex()), $path, $matches);

        return $this->matchToKeys(array_slice($matches, 1));
    }
}