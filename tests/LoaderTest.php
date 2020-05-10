<?php

use \Core\helpers\Loader;
use PHPUnit\Framework\TestCase;

class LoaderTest extends TestCase
{
    protected $loader;

    protected function setUp(): void
    {
        $routes = array(
            "home" => array('foo', 'bar'),
            'about' => array('index', 'profile'),
            'error' => array('404', 'template'),
        );

        $parser_stub = $this->createStub(URLParserTest::class);
        $this->loader = new Loader($routes, $parser_stub);
    }

    /**
     * @dataProvider routeProvider
     */  
    public function testCheckRouteExists($controller, $action, $expected)
    {
        $routes = array(
            "home" => array('login'),
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
