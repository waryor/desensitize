<?php

namespace Waryor\Desensitize\Tests;

use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Waryor\Desensitize\Validator\DesensitizedUriValidator;

class RoutingTests extends TestCase
{
    /** @test */
    public function test_route_compilation()
    {
        $router = $this->setUpRouter();

        $route = $router->get('/folder-name', [
           'uses' => function() {
               return response()->json('success');
           }
        ]);

        $route->matches(new Request());

        $this->assertNotNull($route->getCompiled());
    }

    /** @test */
    public function test_validator_exists()
    {
        $validators = (new Collection(Route::getValidators()))->transform(function ($item, $key) {
            return basename($item::class);
        });

        $basename = basename(DesensitizedUriValidator::class);

        $this->assertContains($basename, $validators, "[$validators] does not contain $basename");
    }

    public function test_routes_without_parameters()
    {
        $router = $this->setUpRouter();

        $route = $router->get('/folder-name', [
            'uses' => function() {
                return response()->json('success');
            }
        ]);
        $request = Request::create('/fOlDeR-nAmE', 'GET');
        $this->assertTrue($route->matches($request));
    }

    /** @test */
    public function test_routes_with_parameters()
    {

    }

    /** @test */
    public function test_routes_with_subfolder()
    {
        $this->setUpRouter('/sub-folder');
    }

    private function setUpRouter($basePath = ''): Router
    {
        $this->setUpDesensitized($basePath);
        return new Router(new Dispatcher());
    }
}