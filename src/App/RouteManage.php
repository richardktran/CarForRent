<?php

namespace Khoatran\CarForRent\App;

use Khoatran\CarForRent\Controller\API\CarAPIController;
use Khoatran\CarForRent\Controller\API\LoginAPIController;
use Khoatran\CarForRent\Controller\CarController;
use Khoatran\CarForRent\Controller\LoginController;
use Khoatran\CarForRent\Middleware\AuthenticateMiddleware;
use Khoatran\CarForRent\Model\UserModel;

class RouteManage
{
    public static function run(): void
    {
        static::apiRoutes();
        static::appRoutes();
    }

    public static function apiRoutes(): void
    {
        Route::post('/api/login', [LoginAPIController::class, 'login']);
        Route::get('/api/cars', [CarAPIController::class, 'listCars']);
    }

    public static function appRoutes(): void
    {
        Route::get('/', [CarController::class, 'index']);
        Route::post('/create', [CarController::class, 'store'], role: UserModel::ROLE_MEMBER);
        Route::get('/create', [CarController::class, 'create'], role: UserModel::ROLE_MEMBER);
        Route::get('/login', [LoginController::class, 'index']);
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/logout', [LoginController::class, 'logout']);
    }
}
