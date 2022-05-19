<?php

namespace Khoatran\CarForRent;

use Khoatran\CarForRent\Controller\CarController;
use Khoatran\CarForRent\Controller\HomeController;
use Khoatran\CarForRent\Controller\LoginController;
use Khoatran\CarForRent\Middleware\AuthenticateMiddleware;

Route::get('/', [new HomeController(), 'index'], [AuthenticateMiddleware::class]);
Route::get('/login', [new LoginController(), 'index']);
Route::post('/login', [new LoginController(), 'login']);
Route::get('/logout', [new LoginController(), 'logout']);
