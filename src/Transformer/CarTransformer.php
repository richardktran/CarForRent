<?php

namespace Khoatran\CarForRent\Transformer;

use Khoatran\CarForRent\Model\Car;
use Khoatran\CarForRent\Model\User;
use Khoatran\CarForRent\Request\CarRequest;

class CarTransformer
{
    public function toArray(Car $car): array
    {
        return [
            'id' => $car->getId(),
            'name' => $car->getName(),
            'description' => $car->getDescription(),
            'type' => $car->getType(),
            'image' => $car->getImage(),
            'price' => $car->getPrice(),
            'brand' => $car->getBrand(),
            'productYear' => $car->getProductionYear(),
            'ownerId' => $car->getOwnerId(),
        ];
    }

    public function requestToArray(CarRequest $car): array
    {
        return [
            'name' => $car->getName(),
            'description' => $car->getDescription(),
            'type' => $car->getType(),
            'image' => $car->getImage(),
            'price' => $car->getPrice(),
            'brand' => $car->getBrand(),
            'productYear' => $car->getProductionYear(),
            'ownerId' => $car->getOwnerId(),
        ];
    }
}
