<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;

class CarController
{
    /**
     * @return false|string
     */
    public function index(): false | string
    {
        return View::render('car');
    }
}
