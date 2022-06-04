<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Service\Business\SessionService;

abstract class AbstractController
{
    protected Request $request;
    protected Response $response;
    protected SessionService $sessionService;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response, SessionService $sessionService)
    {
        $this->request = $request;
        $this->response = $response;
        $this->sessionService = $sessionService;
    }

    public function isLogin(): bool
    {
        return $this->sessionService->isLogin();
    }
}
