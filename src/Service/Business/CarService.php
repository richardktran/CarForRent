<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\Exception\UploadFileException;
use Khoatran\CarForRent\Model\CarModel;
use Khoatran\CarForRent\Repository\CarRepository;
use Khoatran\CarForRent\Request\CarRequest;
use Khoatran\CarForRent\Service\Contracts\CarServiceInterface;

class CarService implements CarServiceInterface
{
    private CarRepository $carRepository;
    private UploadImageService $uploadImageService;

    public function __construct(CarRepository $carRepository, UploadImageService $uploadImageService)
    {
        $this->carRepository = $carRepository;
        $this->uploadImageService = $uploadImageService;
    }

    public function getAll(): array
    {
        return $this->carRepository->findAll(0, 10);
    }


    /**
     * @param CarRequest $carRequest
     * @return CarModel
     * @throws UploadFileException
     */
    public function save(CarRequest $carRequest): ?CarModel
    {
        $isUploadImage = $this->uploadImageService->upload($_FILES['image']);
        if ($isUploadImage == null) {
            throw new UploadFileException("Upload image fail");
        }
        $carRequest->setImage($isUploadImage);
        $insertId = $this->carRepository->insert($carRequest);

        $car = $this->carRepository->findById($insertId);
        if ($car === null) {
            return null;
        }
        return $car;
    }
}
