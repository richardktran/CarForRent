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
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }
        View::render("home");
    }
}
