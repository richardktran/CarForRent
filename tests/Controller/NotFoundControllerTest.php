<?php

namespace Khoatran\Tests\Controller;

use Khoatran\CarForRent\Controller\NotFoundController;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use PHPUnit\Framework\TestCase;

class NotFoundControllerTest extends TestCase
{
    public function testNotFoundRenderView()
    {
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $response = new Response();
        $notFoundController = new NotFoundController($requestMock, $response);
        $result = $notFoundController->index();
        $expectedResult = new Response();
        $expectedResult->setTemplate('_404');
        $this->assertEquals($expectedResult->getTemplate(), $result->getTemplate());
    }
}
