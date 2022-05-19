<?php

namespace Khoatran\CarForRent\Middleware;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Service\SessionService;

class AuthenticateMiddleware implements MiddlewareInterface
{
    /**
     * @return void
     */
    public function run(): void
    {
        if (!SessionService::isLogin()) {
            View::redirect('/login');
            exit();
        }
    }
}
