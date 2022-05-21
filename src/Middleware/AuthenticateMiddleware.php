<?php

namespace Khoatran\CarForRent\Middleware;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Service\Business\SessionService;

class AuthenticateMiddleware implements MiddlewareInterface
{
    private SessionService $sessionService;

    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        if (!$this->sessionService->isLogin()) {
            View::redirect('/login');
            exit();
        }
    }
}
