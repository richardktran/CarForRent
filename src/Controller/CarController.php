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
    private UploadImageService $uploadImageService;
    private ImageValidator $imageValidator;
    private CarValidator $carValidator;

    public function __construct(
        Request $request,
        Response $response,
        SessionService $sessionService,
        CarServiceInterface $carService,
        CarTransformer $carTransformer,
        CarRequest $carRequest,
        UploadImageService $uploadImageService,
        ImageValidator $imageValidator,
        CarValidator $carValidator,
    ) {
        parent::__construct($request, $response, $sessionService);
        $this->carService = $carService;
        $this->carTransformer = $carTransformer;
        $this->carRequest = $carRequest;
        $this->uploadImageService = $uploadImageService;
        $this->imageValidator = $imageValidator;
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
        $errorMessage = [];

        try {
            $requestBody = $this->request->getBody();
            $requestBody = [
                ...$requestBody,
                'image' => "",
                'owner_id' => $this->sessionService->getUserToken()
            ];
            $carRequest = $this->carRequest->fromArray($requestBody);
            $carValidator = $this->carValidator->validateCar($carRequest);
            $fileValidator = $this->imageValidator->validateImage($_FILES['image']);


            $errorMessage = array_merge(is_bool($fileValidator) && $fileValidator ? [] : $fileValidator,
                is_bool($carValidator) && $carValidator ? [] : $carValidator);
            if (empty($errorMessage)) {
                $isUploadImage = $this->uploadImageService->upload($_FILES['image']);
                if ($isUploadImage == null) {
                    throw new UploadFileException("Upload image fail");
                }
                $requestBody = [
                    ...$requestBody,
                    'image' => $isUploadImage,
                ];
                $carRequest = $this->carRequest->fromArray($requestBody);

                $this->carService->save($carRequest);
                return $this->response->renderView('create_car', [
                    'success' => true,
                ]);
            }

        } catch (\Exception $e) {
            if (empty($errorMessage)) {
                $errorMessage = $e->getMessage();
            }
        }
        return $this->response->renderView('create_car', [
            'error' => $errorMessage,
            'car' => $this->carTransformer->requestToArray($carRequest),
        ]);

    }
}
