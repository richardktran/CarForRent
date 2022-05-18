<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;

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
