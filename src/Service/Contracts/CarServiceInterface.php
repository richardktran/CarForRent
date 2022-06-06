<?php

namespace Khoatran\CarForRent\Service\Contracts;

use Khoatran\CarForRent\Model\CarModel;
use Khoatran\CarForRent\Request\CarRequest;

interface CarServiceInterface
{
    public function getAll(): array;

    public function save(CarRequest $carRequest): ?CarModel;
}
