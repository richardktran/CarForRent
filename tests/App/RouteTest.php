<?php

namespace Khoatran\Tests\App;

use Khoatran\CarForRent\App\Route;
use Khoatran\CarForRent\Controller\LoginController;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testAddGetRoute()
    {
        Route::get('/login', [LoginController::class, 'index']);
        $routes = Route::$routes;
        $result = $routes['GET']['/login'];
        $expected = [[LoginController::class, 'index'], []];
        $this->assertEquals($expected, $result);
    }

    public function testAddGetPost()
    {
        Route::post('/login', [LoginController::class, 'index']);
        $routes = Route::$routes;
        $result = $routes['POST']['/login'];
        $expected = [[LoginController::class, 'index'], []];
        $this->assertEquals($expected, $result);
    }
}
