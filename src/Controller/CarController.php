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
    private CarRequest $carRequest;
    private CarValidator $carValidator;

    public function __construct(
        Request             $request,
        Response            $response,
        SessionService      $sessionService,
        CarServiceInterface $carService,
        CarTransformer      $carTransformer,
        CarRequest          $carRequest,
        CarValidator        $carValidator,
    )
    {
        parent::__construct($request, $response, $sessionService);
        $this->carService = $carService;
        $this->carTransformer = $carTransformer;
        $this->carRequest = $carRequest;
        $this->carValidator = $carValidator;
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

    public function create(): Response
    {
        return $this->response->renderView('create_car');
    }

    public function store(): Response
    {
        $owner = $this->sessionService->getUserToken();
        $requestBody = $this->request->getBody();
        $requestBody['owner_id'] = $owner;
        $carRequest = $this->carRequest->fromArray($requestBody);
        $carValidator = $this->carValidator->validateCar($carRequest);

        if (!is_bool($carValidator)) {
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
