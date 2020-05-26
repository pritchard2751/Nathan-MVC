<?php

use \Core\helpers\urlParser;
use PHPUnit\Framework\TestCase;

class URLParserTest extends TestCase 
{
    protected $URLParser;

    protected function setUp(): void
    {
        $params = array('c' => 'controller', 
                        'a' => 'action',
                        'param1' => 'foo', 
                        'param2' => 'bar',
                        'c' => 'another_controller'
        );
    
        $this->URLParser = new URLParser($params);
    }

    public function testGetControllerValue() 
    {
        $actual = $this->URLParser->getControllerValue();
        $this->assertEquals('another_controller', $actual);
    }

    public function testGetActionValue() 
    {
        $actual = $this->URLParser->getActionValue();
        $this->assertEquals('action', $actual);
    }

    public function testGetAddtionalParams() 
    {
        $expected = array('param1' => 'foo', 'param2' => 'bar');
        $actual = $this->URLParser->getAddtionalURLParams();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider redirectParamsProvider
     */
    public function testConstructURL($redirect_params, $expected_url)
    {
        $actual = $this->URLParser->constructURL($redirect_params);
        $this->assertSame($expected_url, $actual); 
    }

    public function redirectParamsProvider(): array
    {
        return [
            'redirect' => [
                array('controller' => 'home', 'action' => 'index'), 
                '?c=home&a=index'],
            'redirect with additional params' => [
                array('controller' => 'about', 'action' => 'people', 
                'params' => array('additional' => 1, 'another' => 'thing')),
                '?c=about&a=people&additional=1&another=thing'],
            'redirect with incorrect keys' => [
                array ('c' => 'home', 'a' => 'index', 'more' => array('another' => 1)), 
                ''],
            'redirect with controller only' => [
                array('controller' => 'about'), 
                '?c=about'],
            'redirect with action only' => [
                array('action' => 'company'), 
                '?a=company'],
            'redirect with additional params only' => [
                array('params' => array('additional' => 1, 'another' => 'thing')), 
                '?additional=1&another=thing'],
            'redirect with controller only' => [
                array('controller' => 'about'), 
                '?c=about']
        ];
    }
}