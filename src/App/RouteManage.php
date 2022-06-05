<?php

namespace Khoatran\CarForRent\App;

use Khoatran\CarForRent\Controller\API\CarAPIController;
use Khoatran\CarForRent\Controller\API\LoginAPIController;
use Khoatran\CarForRent\Controller\CarController;
use Khoatran\CarForRent\Controller\LoginController;
use Khoatran\CarForRent\Controller\RegisterController;
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
        Route::get('/create', [CarController::class, 'store'], role: UserModel::ROLE_ADMIN);
        Route::post('/create', [CarController::class, 'store'], role: UserModel::ROLE_ADMIN);
        Route::get('/login', [LoginController::class, 'login']);
        Route::post('/login', [LoginController::class, 'login']);
        Route::get('/register', [RegisterController::class, 'register']);
        Route::post('/register', [RegisterController::class, 'register']);
        Route::post('/logout', [LoginController::class, 'logout']);
    }
}
