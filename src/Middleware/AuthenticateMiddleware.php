<?php

namespace Khoatran\CarForRent\Middleware;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;

class AuthenticateMiddleware implements MiddlewareInterface
{
    private SessionServiceInterface $sessionService;

    public function __construct(SessionServiceInterface $sessionService)
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
