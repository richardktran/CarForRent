<?php

namespace Khoatran\CarForRent\App;

use Khoatran\CarForRent\Controller\API\LoginControllerAPI;
use Khoatran\CarForRent\Controller\HomeController;
use Khoatran\CarForRent\Controller\LoginController;
use Khoatran\CarForRent\Middleware\AuthenticateMiddleware;

class RouteManage
{
    public static function run(): void
    {
        Route::get('/', [HomeController::class, 'index'], [AuthenticateMiddleware::class]);
        Route::get('/login', [LoginController::class, 'index']);
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/logout', [LoginController::class, 'logout']);

        Route::post('/api/login', [LoginControllerAPI::class, 'login']);
    }
}
