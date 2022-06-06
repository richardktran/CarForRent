<?php

namespace Khoatran\Tests\Validator;

use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Request\CarRequest;
use Khoatran\CarForRent\Validator\CarValidator;
use Khoatran\CarForRent\Validator\ImageValidator;
use PHPUnit\Framework\TestCase;

class CarValidatorTest extends TestCase
{
    public function testWithErrorImage()
    {
        $car = $this->getCarRequest(
            'BMW', 20, 'type',
            'image.jpg', '2022',
            'description', 'image.png'
        );

        $imageValidatorMock = $this->getMockBuilder(ImageValidator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $imageValidatorMock->expects($this->once())
            ->method('validateImage')
            ->willReturn([
                'image' => 'error',
            ]);
        $requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $requestMock->expects($this->once())
            ->method('getFile')
            ->willReturn(['image' => 'image.jpg']);

        $carValidator = new CarValidator($imageValidatorMock, $requestMock);

        $errors = $carValidator->validateCar($car);
        $this->assertFalse(empty($errors));
    }

    public function testWithSuccess()
    {
        $car = $this->getCarRequest(
            'BMW', 20, 'type',
            'image.jpg', '2022',
            'description', 'image.png'
        );

        $imageValidatorMock = $this->getMockBuilder(ImageValidator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $imageValidatorMock->expects($this->once())
            ->method('validateImage')
            ->willReturn([]);
        $requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $requestMock->expects($this->once())
            ->method('getFile')
            ->willReturn(['image' => 'image.jpg']);

        $carValidator = new CarValidator($imageValidatorMock, $requestMock);

        $errors = $carValidator->validateCar($car);
        $this->assertTrue(empty($errors));
    }

    public function testWithFail()
    {
        $car = $this->getCarRequest(
            'BMW', 0, 't',
            'image.jpg', '2022',
            'description', 'image.png'
        );

        $imageValidatorMock = $this->getMockBuilder(ImageValidator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $imageValidatorMock->expects($this->once())
            ->method('validateImage')
            ->willReturn([]);
        $requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $requestMock->expects($this->once())
            ->method('getFile')
            ->willReturn(['image' => 'image.jpg']);

        $carValidator = new CarValidator($imageValidatorMock, $requestMock);

        $errors = $carValidator->validateCar($car);
        $this->assertFalse(empty($errors));
    }

    private function getCarRequest(
        string $name,
        int $price,
        string $type,
        string $brand,
        string $productionYear,
        string $description,
        string $image
    ): CarRequest {
        $car = new CarRequest();
        $car->setName($name);
        $car->setType($type);
        $car->setBrand($brand);
        $car->setProductionYear($productionYear);
        $car->setPrice($price);
        $car->setDescription($description);
        $car->setImage($image);

        return $car;
    }
}
