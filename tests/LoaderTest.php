<?php

use \Core\helpers\Loader;
use \Core\helpers\urlParser;
use \Core\helpers\ControllerLoader;
use PHPUnit\Framework\TestCase;

class LoaderTest extends TestCase
{
    protected $routes;
    protected $parser_stub;

    protected function setUp(): void
    {
        $this->routes = array('routes' => array());
        $this->routes['default_controller'] = 'home';
        $this->routes['default_action'] = 'index';
        $this->routes['404_controller'] = 'error';
        $this->routes['404_action'] = 'index';

        $this->routes['routes']['home'] = array('index', 'login');
        $this->routes['routes']['about'] = array('index', 'profile');
        $this->routes['routes']['error'] = array('index');                           

        $this->parser_stub = $this->createStub(URLParser::class);
        $this->parser_stub->method('getAddtionalURLParams')->willReturn(array());
    }

    public function testNoParamsDefaultRoute()
    {
        $this->parser_stub->method('getControllerValue')->willReturn('');
        $this->parser_stub->method('getActionValue')->willReturn('');

        $loader = new Loader($this->routes, $this->parser_stub);

        $this->assertSame('home', $loader->getController());
        $this->assertSame('index', $loader->getAction());
    }

    public function testControllerParamDefaultController()
    {
        $this->parser_stub->method('getControllerValue')->willReturn('');
        $this->parser_stub->method('getActionValue')->willReturn('index');

        $loader = new Loader($this->routes, $this->parser_stub);

        $this->assertSame('home', $loader->getController());
        $this->assertSame('index', $loader->getAction());
    }

    public function testControllerParamDefaultAction()
    {
        $this->parser_stub->method('getControllerValue')->willReturn('about');
        $this->parser_stub->method('getActionValue')->willReturn('');

        $loader = new Loader($this->routes, $this->parser_stub);

        $this->assertSame('about', $loader->getController());
        $this->assertSame('index', $loader->getAction());
    }

    public function testControllerActionParams()
    {
        $this->parser_stub->method('getControllerValue')->willReturn('about');
        $this->parser_stub->method('getActionValue')->willReturn('index');

        $loader = new Loader($this->routes, $this->parser_stub);

        $this->assertSame('about', $loader->getController());
        $this->assertSame('index', $loader->getAction());
    }

    public function testInvalidRoute()
    {
        $this->parser_stub->method('getControllerValue')->willReturn('invalid');
        $this->parser_stub->method('getActionValue')->willReturn('route');

        $loader = new Loader($this->routes, $this->parser_stub);

        $this->assertSame('error', $loader->getController());
        $this->assertSame('index', $loader->getAction());
    }

    /**
     * @dataProvider routeProvider
     */  
    public function testCheckRouteExists($controller, $action, $expected)
    {
        $loader = new Loader($this->routes, $this->parser_stub);
        $actual = $loader->routeExists($this->routes, $controller, $action);
        $this->assertSame($expected, $actual);
    }

    public function routeProvider(): array
    {
        return [
            'valid route' => ['home', 'login', true],
            'matches a controller but not an action' => ['home', 'foo', false],
            'matches an action but not controller' => ['foocontroller', 'profile', false],
            'does not match a controller or an action' => ['my', 'route', false]
        ];
    }
}
