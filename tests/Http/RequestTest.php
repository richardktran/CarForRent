<?php

namespace Khoatran\Tests\Http;

use Khoatran\CarForRent\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testGetPath()
    {
        $request = new Request();
        $_SERVER['REQUEST_URI'] = '/login?redirect=true';
        $this->assertEquals('/login', $request->getPath());
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
}
