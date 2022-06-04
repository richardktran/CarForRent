<?php

namespace Khoatran\CarForRent\Controller\API;

use Khoatran\CarForRent\Controller\AbstractController;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;

class AbstractAPIController
{
    protected Request $request;
    protected Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
