<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;

class NotFoundController extends AbstractController
{
    public function __construct(Request $request, Response $response, $sessionService)
    {
        parent::__construct($request, $response, $sessionService);
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->response->renderView('_404', statusCode: 404);
    }
}
