<?php

namespace Khoatran\CarForRent\Controller\API;

use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Service\Contracts\CarServiceInterface;
use Khoatran\CarForRent\Transformer\CarTransformer;

class CarAPIController extends AbstractAPIController
{
    private CarServiceInterface $carService;
    private CarTransformer $carTransformer;

    public function __construct(Request $request, Response $response, CarServiceInterface $carService, CarTransformer $carTransformer)
    {
        parent::__construct($request, $response);
        $this->carService = $carService;
        $this->carTransformer = $carTransformer;
    }

    public function listCars(): Response
    {
        $cars = $this->carService->getAll();
        $results = [];
        foreach ($cars as $car) {
            $results[] = $this->carTransformer->toArray($car);
        }
        return $this->response->toJson(['data' => $results], 200);
    }
}
