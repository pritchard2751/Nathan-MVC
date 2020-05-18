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
}