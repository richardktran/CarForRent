<?php

namespace Khoatran\Tests\Middleware;

use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Middleware\AuthenticateMiddleware;
use Khoatran\CarForRent\Service\Business\SessionService;
use PHPUnit\Framework\TestCase;

class AuthenticateMiddlewareTest extends TestCase
{
    public function testRequestByPassMiddleware()
    {
        $responseMock = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock->method('isLogin')->willReturn(true);
        $authenticate = new AuthenticateMiddleware($responseMock, $sessionServiceMock);
        $result = $authenticate->run();
        $this->assertTrue($result);
    }

    public function testRequestNotByPassMiddleware()
    {
        $responseMock = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock->method('isLogin')->willReturn(false);
        $authenticate = new AuthenticateMiddleware($responseMock, $sessionServiceMock);
        $result = $authenticate->run();
        $result = $result instanceof Response;
        $this->assertTrue($result);
    }
}
