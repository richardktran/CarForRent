<?php

namespace Khoatran\Tests\Controller;

use Khoatran\CarForRent\Controller\CarController;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    public function testRenderToView()
    {
        $request = new Request();
        $response = new Response();
        $loginController = new CarController($request, $response);
        $loginController = $loginController->index();

        $expectedResult = new Response();
        $expectedResult->setTemplate('home');

        $this->assertEquals($expectedResult, $loginController);
    }
}
