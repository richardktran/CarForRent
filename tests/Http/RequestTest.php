<?php

namespace Khoatran\Tests\Http;

use Khoatran\CarForRent\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * @dataProvider getPathProvider
     * @return void
     */
    public function testGetPath($param, $expected)
    {
        $request = new Request();
        $_SERVER['REQUEST_URI'] = $param;
        $this->assertEquals($expected, $request->getPath());
    }

    /**
     * @dataProvider getMethodProvider
     * @return void
     */
    public function testGetMethod($param)
    {
        $request = new Request();
        $_SERVER['REQUEST_METHOD'] = $param;
        $this->assertEquals($param, $request->getMethod());
    }

    public function getMethodProvider()
    {
        return [
            ['GET'],
            ['POST'],
            ['PUT'],
            ['DELETE'],
            ['PATCH'],
            ['HEAD'],
            ['OPTIONS'],
        ];
    }

    public function getPathProvider()
    {
        return [
            'get-path-case-1' => [
                'param' => '/login?redirect=true',
                'expected' => '/login',
            ],
            'get-path-case-2' => [
                'param' => '/login',
                'expected' => '/login',
            ],
            'get-path-case-3' => [
                'param' => '/home?redirect=true',
                'expected' => '/home',
            ],
        ];
    }
}
