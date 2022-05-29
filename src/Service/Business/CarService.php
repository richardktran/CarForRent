<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\Repository\CarRepository;
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
        return $this->carRepository->getAllCars();
    }
}
