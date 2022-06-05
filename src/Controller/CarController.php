<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Exception\UploadFileException;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Model\CarModel;
use Khoatran\CarForRent\Request\CarRequest;
use Khoatran\CarForRent\Service\Business\SessionService;
use Khoatran\CarForRent\Service\Business\UploadImageService;
use Khoatran\CarForRent\Service\Contracts\CarServiceInterface;
use Khoatran\CarForRent\Transformer\CarTransformer;
use Khoatran\CarForRent\Validator\CarValidator;
use Khoatran\CarForRent\Validator\FileValidator;
use Khoatran\CarForRent\Validator\ImageValidator;

class CarController extends AbstractController
{
    private CarServiceInterface $carService;
    private CarTransformer $carTransformer;

    public function __construct(
        Request             $request,
        Response            $response,
        SessionService      $sessionService,
        CarServiceInterface $carService,
        CarTransformer      $carTransformer
    )
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

    public function store(CarRequest $carRequest, CarValidator $carValidator): Response
    {
        if ($this->request->isGet()) {
            return $this->response->renderView('create_car');
        }
        $owner = $this->sessionService->getUserToken();
        $requestBody = $this->request->getBody();
        $requestBody['owner_id'] = $owner;
        $carRequest = $carRequest->fromArray($requestBody);
        $carValidator = $carValidator->validateCar($carRequest);

        if (!empty($carValidator)) {
            return $this->response->renderView('create_car', [
                'error' => $carValidator,
                'car' => $this->carTransformer->requestToArray($carRequest),
            ]);
        }
        $this->carService->save($carRequest);
        return $this->response->renderView('create_car', [
            'success' => true,
        ]);
    }
}
