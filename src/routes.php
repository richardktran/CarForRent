<?php

namespace Khoatran\CarForRent;

use Khoatran\CarForRent\Controller\CarController;
use Khoatran\CarForRent\Controller\HomeController;
use Khoatran\CarForRent\Controller\LoginController;

Route::get('/', [new HomeController(), 'index']);
Route::get('/login', [new LoginController(), 'index']);
Route::post('/login', [new LoginController(), 'login']);
