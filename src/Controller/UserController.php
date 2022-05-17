<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;

class UserController
{
    /**
     * @return false|string
     */
    public function index(): false|string
    {
        return View::render('user');
    }
}
