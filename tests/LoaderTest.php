<?php

use \Core\helpers\Loader;
use \Core\helpers\urlParser;
use PHPUnit\Framework\TestCase;

class LoaderTest extends TestCase
{
    protected $loader;
    protected $routes;

    protected function setUp(): void
    {
        $this->routes = array(
            'home' => array('index', 'bar', 'login'),
            'foo' => array('index','bar'),
            'about' => array('people', 'company')
        );

        $parser_stub = $this->createStub(URLParser::class);
        $this->loader = new Loader($this->routes, $parser_stub);
    }

    public function testNoParamsDefaultRoute()
    {
        $parser_stub = $this->createStub(URLParser::class);

        $parser_stub->method('getControllerValue')->willReturn('');
        $parser_stub->method('getActionValue')->willReturn('');

        $this->loader = new Loader($this->routes, $parser_stub);

        $this->assertSame('home', $this->loader->getControllerName());
        $this->assertSame('index', $this->loader->getAction());
    }

    public function testControllerParamDefaultAction()
    {
        $parser_stub = $this->createStub(URLParser::class);

        $parser_stub->method('getControllerValue')->willReturn('foo');
        $parser_stub->method('getActionValue')->willReturn('');

        $this->loader = new Loader($this->routes, $parser_stub);

        $this->assertSame('foo', $this->loader->getControllerName());
        $this->assertSame('index', $this->loader->getAction());
    }

    public function testControllerActionParams()
    {
        $parser_stub = $this->createStub(URLParser::class);

        $parser_stub->method('getControllerValue')->willReturn('foo');
        $parser_stub->method('getActionValue')->willReturn('bar');

        $this->loader = new Loader($this->routes, $parser_stub);

        $this->assertSame('foo', $this->loader->getControllerName());
        $this->assertSame('bar', $this->loader->getAction());
    }

    public function testInvalidRoute()
    {
        $parser_stub = $this->createStub(URLParser::class);

        $parser_stub->method('getControllerValue')->willReturn('invalid');
        $parser_stub->method('getActionValue')->willReturn('route');

        $this->loader = new Loader($this->routes, $parser_stub);

        $this->assertSame('error', $this->loader->getControllerName());
        $this->assertSame('badURL', $this->loader->getAction());
    }

    /**
     * @dataProvider routeProvider
     */  
    public function testCheckRouteExists($controller, $action, $expected)
    {
        $routes = array(
            'home' => array('login'),
            'about' => array('index', 'profile'),
            'error' => array('404', 'template'),
        );

        $actual = $this->loader->routeExists($routes, $controller, $action);
        $this->assertSame($expected, $actual);
    }

    public function routeProvider(): array
    {
        return [
            'valid route'  => ['home', 'login', true],
            'does not match a controller or action' => ['my', 'route', false],
            'matches a controller but not an action' => ['home', 'foo', false],
            'matches an action but not controller' => ['foocontroller', 'profile', false]
        ];
    } 
}
