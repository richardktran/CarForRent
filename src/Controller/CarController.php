<?php

namespace Khoatran\CarForRent\Controller;

class CarController extends BaseController
{
    /**
     * @return false|string
     */
    public function index(): false | string
    {
        return $this->render('car');
    }
}
