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
        View::render("home");
    }
}
