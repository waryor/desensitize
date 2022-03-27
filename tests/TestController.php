<?php

namespace Waryor\Desensitize\Tests;

use Illuminate\Routing\Controller;

class TestController extends Controller
{

    public function returns_empty(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return \response('success');
    }

    public function with_id($id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return \response($id);
    }
}