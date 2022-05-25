<?php

namespace Khoatran\Tests\App;

use Khoatran\CarForRent\App\Route;
use Khoatran\CarForRent\App\RouteManage;
use Khoatran\CarForRent\Controller\LoginController;
use Khoatran\CarForRent\Http\Request;
use PHPUnit\Framework\TestCase;

class RouteManageTest extends TestCase
{
    /**
     * @dataProvider routeProvider
     * @return void
     */
    public function testLoginCanBeAddedToRoute($params, $expected)
    {
        RouteManage::run();
        $_SERVER['REQUEST_METHOD'] = $params['method'];
        $_SERVER['REQUEST_URI'] = $params['path'];
        $request = new Request();
        $path = $request->getPath();
        $method = $request->getMethod();

        $response = Route::$routes[$method][$path] ?? false;
        $this->assertEquals($expected, $response[0]);
        $this->assertEquals($expected, $response[0]);
    }

    public function routeProvider()
    {
        return [
            'route-test-1' => [
                'params' => [
                    'method' => 'GET',
                    'path' => '/login',

                ],
                'expected' => [LoginController::class, 'index']
            ],
            'route-test-2' => [
                'params' => [
                    'method' => 'POST',
                    'path' => '/login'
                ],
                'expected' => [LoginController::class, 'login'],
            ],
//            'route-test-3' => [
//                'params' => [
//                    'method' => 'GET',
//                    'path' => '/ssss'
//                ],
//                'expected' => false
//            ],
        ];
    }

    /**
     * @dataProvider routeProviderNotFound
     * @param $params
     * @param $expected
     * @return void
     */
    public function testRouteNotFound($params, $expected)
    {
        RouteManage::run();
        $_SERVER['REQUEST_METHOD'] = $params['method'];
        $_SERVER['REQUEST_URI'] = $params['path'];
        $request = new Request();
        $path = $request->getPath();
        $method = $request->getMethod();

        $response = Route::$routes[$method][$path] ?? false;
        $this->assertEquals($expected, $response);
    }

    public function routeProviderNotFound()
    {
        return [
            'route-test-1' => [
                'params' => [
                    'method' => 'GET',
                    'path' => '/ssss'
                ],
                'expected' => false
            ],
            'route-test-2' => [
                'params' => [
                    'method' => 'POST',
                    'path' => '/sssadasddsafss'
                ],
                'expected' => false
            ],
        ];
    }
}
