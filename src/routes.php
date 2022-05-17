<?php

namespace Khoatran\CarForRent;

use Khoatran\CarForRent\Controller\CarController;
use Khoatran\CarForRent\Controller\UserController;

Route::get('/', [new UserController(), 'index']);
Route::get('/car', [new CarController(), 'index']);
