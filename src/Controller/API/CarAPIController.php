<?php

namespace Khoatran\CarForRent\Controller\API;

use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;

class CarAPIController extends AbstractAPIController
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function index(): Response
    {
        return $this->response->toJson(
            [
                'name' => 'Car For Rent API',
                'version' => '1.0'
            ],
            Response::HTTP_OK
        );
    }
}
