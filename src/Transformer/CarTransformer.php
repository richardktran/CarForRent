<?php

namespace Khoatran\CarForRent\Transformer;

use Khoatran\CarForRent\Model\CarModel;
use Khoatran\CarForRent\Model\UserModel;

class CarTransformer
{
    public function toArray(CarModel $car): array
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
}
