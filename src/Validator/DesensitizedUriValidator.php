<?php

namespace Waryor\Desensitize\Validator;

use Illuminate\Http\Request;
use Illuminate\Routing\Matching\ValidatorInterface;
use Illuminate\Routing\Route;

/**
 * Class DesensitizedUriValidator
 * @package Waryor\Desensitize
 */
class DesensitizedUriValidator implements ValidatorInterface
{
    /**
     * Base path to include in the desensitized URL.
     *
     * @var string
     */
    private string $basePath;

    /**
     * Constructor
     *
     * @param string $basePath
     */
    public function __construct(string $basePath = '')
    {
        $this->basePath = $basePath;
    }

    /**
     * @param Route $route
     * @param Request $request
     * @return bool|int
     */
    public function matches(Route $route, Request $request, &$matches = null)
    {
        $path = $request->path() == '/' ? '/' : '/' . $request->path();

        if(!str_contains(strtolower($path), $this->basePath))
        {
            $path = $this->basePath . $path;
        }

        if(!str_starts_with($path, '/'))
        {
            $path = '/' . $path;
        }

        $path = strtolower($path);

        $regex = $route->getCompiled()->getRegex();

        $regexEncoded = str_replace('-', '\-', $this->basePath);

        /* Route:  /runs/{id}
         * Regex: {^/runs/(?P<id>[^/]++)$}sDu
         * Path: /runs/435
         *
         * If we have a subfolder we need to append the subfolder:
         * to regex: {^/sub-folder/runs/(?P<id>[^/]++)$}sDu
         * to path: /sub-folder/runs/435
         */
        $regex = str_replace('{^', '{^' . $regexEncoded, $regex);

        $regex = preg_replace('/$/','i', $regex);

        $val =  preg_match($regex, $path, $matches);

        if($val == 0)
        {
            //dd("did not match: $regex -> $path");
        }

        return $val;
    }

    public function getBasePath() : string
    {
        return $this->basePath;
    }
}