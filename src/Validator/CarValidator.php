<?php

namespace Khoatran\CarForRent\Validator;

use Khoatran\CarForRent\Request\CarRequest;

class CarValidator extends Validator
{
    public function validateCar(CarRequest $car)
    {
        $this->name('car_name')->value($car->getName())->required()->max(70);
        $this->name('car_type')->value($car->getType())->required()->min(3)->max(255);
        $this->name('car_brand')->value($car->getBrand())->required()->min(3)->max(255);
        $this->name('car_year')->value($car->getProductionYear())->required()->min(1900)->max(2022);
        $this->name('car_price')->value($car->getPrice())->required()->min(1);
        $this->name('car_description')->value($car->getDescription());
        if ($this->isSuccess()) {
            return true;
        } else {
            return $this->getErrors();
        }
    }
}
