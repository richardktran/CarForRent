<?php

namespace Khoatran\CarForRent\Controller;

class UserController extends BaseController
{
    /**
     * @return false|string
     */
    public function index(): false | string
    {
        return $this->render('user');
    }
}
