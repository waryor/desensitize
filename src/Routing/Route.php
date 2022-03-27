<?php

namespace Waryor\Desensitize\Routing;

use Illuminate\Http\Request;
use Waryor\Desensitize\Validator\DesensitizedUriValidator;

class Route extends \Illuminate\Routing\Route
{
    /**
     * Bind the route to a given request for execution.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Route
     */
    public function bind(Request $request)
    {
        $this->compileRoute();

        $this->parameters = (new RouteParameterBinder($this))
            ->parameters($request);


        $this->originalParameters = $this->parameters;

        return $this;
    }

    public function getUriValidator() : DesensitizedUriValidator
    {
        foreach(Route::getValidators() as $validator)
        {
            if(get_class($validator) === DesensitizedUriValidator::class)
            {
                return $validator;
            }
        }
    }
}
