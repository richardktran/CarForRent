<?php

namespace Khoatran\CarForRent\Middleware;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;

class AuthenticateMiddleware implements MiddlewareInterface
{
    private SessionServiceInterface $sessionService;
    private Response $response;

    public function __construct(Response $response, SessionServiceInterface $sessionService)
    {
        $this->sessionService = $sessionService;
        $this->response = $response;
    }

    /**
     * @return Response|bool
     */
    public function run(): Response|bool
    {
        if (!$this->sessionService->isLogin()) {
            return $this->response->redirect('/login');
        }
        return true;
    }
}
