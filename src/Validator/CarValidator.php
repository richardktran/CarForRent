<?php

namespace Khoatran\CarForRent\Validator;

use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Request\CarRequest;

class CarValidator extends Validator
{
    private ImageValidator $imageValidator;
    private Request $request;

    public function __construct(ImageValidator $imageValidator, Request $request)
    {
        $this->imageValidator = $imageValidator;
        $this->request = $request;
    }

    /**
     * @param CarRequest $car
     * @return array|bool
     */
    public function validateCar(CarRequest $car): array|bool
    {
        $this->name('car_name')->value($car->getName())->required()->max(70);
        $this->name('car_type')->value($car->getType())->required()->min(3)->max(255);
        $this->name('car_brand')->value($car->getBrand())->required()->min(3)->max(255);
        $this->name('car_year')->value($car->getProductionYear())->required()->min(1900)->max(2022);
        $this->name('car_price')->value($car->getPrice())->required()->min(1);
        $this->name('car_description')->value($car->getDescription());
        $files = $this->request->getFile();
        $imageValidator = $this->imageValidator->validateImage($files['image']);

        if ($this->isSuccess() && $imageValidator) {
            return true;
        } else {
            return array_merge($this->getErrors(), $imageValidator);
        }
    }
}
