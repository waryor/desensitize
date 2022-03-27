<?php

namespace Waryor\Desensitize\Tests;

use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Waryor\Desensitize\Routing\Route;
use Waryor\Desensitize\Routing\Router;
use Waryor\Desensitize\Validator\DesensitizedUriValidator;

/**
 * @runTestsInSeparateProcesses
 */
class RoutingTests extends TestCase
{
    //use WithFaker;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        //$this->setUpFaker();
    }

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
        $this->setUpRouter();
        $validators = (new Collection(Route::getValidators()))->transform(function ($item, $key) {
            return basename($item::class);
        });

        $basename = basename(DesensitizedUriValidator::class);

        $this->assertContains($basename, $validators, "[$validators] does not contain $basename");
    }

    /** @test */
    public function test_validator_base_path_is_set_correctly()
    {
        $basepath = 'some-fancy-name';
        $router = $this->setUpRouter($basepath);
        $route = $router->get('/dummy', function (){});
        $this->assertEquals($basepath, $route->getUriValidator()->getBasePath());
    }

    /** @test */
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
        $this->markTestSkipped('must be revisited.');
        $router = $this->setUpRouter();
        $route = $router->get('/controller/{id}', 'TestController@with_id');
        $request = Request::create('/cOnTrOlLeR/10', 'GET');

        $route->bind($request);
        $this->assertTrue($route->matches($request));

        $this->assertNotEmpty($route->parameters, 'route has no parameters but should have at least one');
    }

    /** @test */
    public function test_routes_with_subfolder()
    {
        $router = $this->setUpRouter('/sub-folder');

        $route = $router->get('/folder-name/controller', [
            'uses' => function() {
                return response()->json('success');
            }
        ]);
        $request = Request::create('/fOlDeR-nAmE/controller', 'GET');
        $this->assertTrue($route->matches($request));
    }

    /** @test */
    public function test_routes_with_subfolder_and_parameters()
    {
        $this->markTestSkipped('must be revisited.');
        $router = $this->setUpRouter('/folder-name');

        $route = $router->get('/some-controller/{id}', 'TestController@with_id');
        $request = Request::create('/folder-name/some-controller/44', 'GET');

        $route->bind($request);
        $regex = $route->getCompiled()->getRegex();

        $this->assertTrue($route->matches($request), "route $route->uri did not match regex: $regex");

        $this->assertNotEmpty($route->parameters, 'route has no parameters but should have at least one');
    }

    private function setUpRouter($basePath = ''): Router
    {
        $this->setUpDesensitized($basePath);
        return new Router(new Dispatcher());
    }
}