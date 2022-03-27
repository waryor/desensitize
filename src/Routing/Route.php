<?php

namespace Waryor\Desensitize\Routing;

use Illuminate\Http\Request;

class Route extends \Illuminate\Routing\Route
{
    /**
     * Bind the route to a given request for execution.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Route
     */
    public function bind(Request $request)
    {
        $this->compileRoute();

        $this->parameters = (new RouteParameterBinder($this))
            ->parameters($request);

        $this->originalParameters = $this->parameters;

        return $this;
    }
}
