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
    public function matches(Route $route, Request $request, &$matches = null): bool|int
    {
        $path = $request->path() == '/' ? '/' : '/' . $request->path();
        $path = str_replace(strtolower($this->getBasePath()), '', strtolower($path));

        if(!str_starts_with($path, '/'))
        {
            $path = '/' . $path;
        }

        $regex = $route->getCompiled()->getRegex();

        /* Route:  /runs/{id}
         * Regex: {^/runs/(?P<id>[^/]++)$}sDu
         * Path: /runs/435
         *
         * If we have a subfolder we need to append the subfolder:
         * to regex: {^/runs/(?P<id>[^/]++)$}sDu
         * to path: /sub-folder/runs/435 but sub-folder has been replaced before
         */

        $regex = preg_replace('/$/','i', $regex);
        return preg_match($regex, $path, $matches);
    }

    public function getBasePath() : string
    {
        return $this->basePath;
    }
}