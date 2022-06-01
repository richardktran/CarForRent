<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Model\CarModel;
use Khoatran\CarForRent\Request\CarRequest;
use Khoatran\CarForRent\Service\Business\SessionService;
use Khoatran\CarForRent\Service\Business\UploadImageService;
use Khoatran\CarForRent\Service\Contracts\CarServiceInterface;
use Khoatran\CarForRent\Transformer\CarTransformer;

class CarController extends AbstractController
{
    private CarServiceInterface $carService;
    private CarTransformer $carTransformer;
    private CarRequest $carRequest;
    private UploadImageService $uploadImageService;

    public function __construct(
        Request $request,
        Response $response,
        SessionService $sessionService,
        CarServiceInterface $carService,
        CarTransformer $carTransformer,
        CarRequest $carRequest,
        UploadImageService $uploadImageService
    ) {
        parent::__construct($request, $response, $sessionService);
        $this->carService = $carService;
        $this->carTransformer = $carTransformer;
        $this->carRequest = $carRequest;
        $this->uploadImageService = $uploadImageService;
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
        $errorMessage = [];

        try {
            $requestBody = $this->request->getBody();
            $isUploadImage = $this->uploadImageService->upload($_FILES['image']);
            $requestBody = [
                ...$requestBody,
                'image' => $isUploadImage,
                'owner_id' => $this->sessionService->getUserToken()
            ];
            $carRequest = $this->carRequest->fromArray($requestBody);
            $errorMessage = [...$errorMessage, $carRequest->validate()];

            $car = $this->carService->save($carRequest);
        } catch (\Exception $e) {
            $car = new CarModel();
            $errorMessage[] = 'The our system went something wrong!';
        }

        return $this->response->redirect('/');
    }
}
