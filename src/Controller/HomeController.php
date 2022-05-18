<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Service\SessionService;

class HomeController
{

    /**
     * @return void
     */
    public function index(): void
    {
        if (SessionService::getUserId()==null) {
            View::redirect('/login');
        }
        View::render("home");
    }
}
