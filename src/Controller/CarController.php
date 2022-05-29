<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Service\Business\SessionService;
use Khoatran\CarForRent\Service\Contracts\CarServiceInterface;
use Khoatran\CarForRent\Transformer\CarTransformer;

class CarController extends AbstractController
{
    private CarServiceInterface $carService;
    private CarTransformer $carTransformer;

    public function __construct(Request $request, Response $response, SessionService $sessionService, CarServiceInterface $carService, CarTransformer $carTransformer)
    {
        parent::__construct($request, $response, $sessionService);
        $this->carService = $carService;
        $this->carTransformer = $carTransformer;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $cars = $this->carService->getAll();
        $results = [];
        foreach ($cars as $car) {
            $results[] = $this->carTransformer->toArray($car);
        }
        return $this->response->renderView('home', ['cars' => $results]);
    }
}
