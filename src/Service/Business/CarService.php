<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\Model\CarModel;
use Khoatran\CarForRent\Repository\CarRepository;
use Khoatran\CarForRent\Request\CarRequest;
use Khoatran\CarForRent\Service\Contracts\CarServiceInterface;

class CarService implements CarServiceInterface
{
    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function getAll(): array
    {
        return $this->carRepository->findAll(0, 10);
    }


    public function save(CarRequest $carRequest): CarModel
    {
        $insertId = $this->carRepository->insert($carRequest);
        if (!$insertId) {
            return new CarModel();
        }
        $car = $this->carRepository->findById($insertId);
        if ($car === null) {
            return new CarModel();
        }
        return $car;
    }
}
