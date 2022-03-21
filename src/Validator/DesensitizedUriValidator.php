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
    public function matches(Route $route, Request $request)
    {
        $path = $request->path() == '/' ? '/' : '/' . $request->path();

        if(!str_contains(strtolower($path), $this->basePath))
        {
            $path = $this->basePath . $path;
        }

        $path = strtolower($path);
        $regex = $route->getCompiled()->getRegex();
        $regex = str_replace('^', "^{$this->basePath}", $regex);

        return preg_match(preg_replace('/$/','i', $regex), rawurldecode($path));
    }
}