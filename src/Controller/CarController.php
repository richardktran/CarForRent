<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Service\Business\SessionService;

class CarController extends AbstractController
{
    public function __construct(Request $request, Response $response, SessionService $sessionService)
    {
        parent::__construct($request, $response, $sessionService);
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->response->renderView('home');
    }
}
