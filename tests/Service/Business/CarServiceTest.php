<?php

namespace Khoatran\Tests\Service\Business;

use Khoatran\CarForRent\Exception\UploadFileException;
use Khoatran\CarForRent\Model\Car;
use Khoatran\CarForRent\Repository\CarRepository;
use Khoatran\CarForRent\Request\CarRequest;
use Khoatran\CarForRent\Service\Business\CarService;
use Khoatran\CarForRent\Service\Business\UploadImageService;
use PHPUnit\Framework\TestCase;

class CarServiceTest extends TestCase
{

    public function testGetAllCar()
    {
        $carArray = [
            $this->getCar(2, 'car1', 'descriptcar1', 'image', 2000),
            $this->getCar(3, 'car2', 'descriptcar2', 'image', 3000),
        ];
        $carRepositoryMock = $this->getMockBuilder(CarRepository::class)->disableOriginalConstructor()->getMock();
        $carRepositoryMock->expects($this->once())->method('findAll')->willReturn($carArray);
        $uploadImageServiceMock = $this->getMockBuilder(UploadImageService::class)->disableOriginalConstructor()->getMock();
        $carService = new CarService($carRepositoryMock, $uploadImageServiceMock);
        $cars = $carService->getAll();
        $this->assertEquals(2, count($cars));
    }

    public function testUploadImageFail()
    {
        $carRepositoryMock = $this->getMockBuilder(CarRepository::class)->disableOriginalConstructor()->getMock();
        $uploadImageServiceMock = $this->getMockBuilder(UploadImageService::class)->disableOriginalConstructor()->getMock();
        $uploadImageServiceMock->expects($this->once())->method('upload')->willReturn(null);
        $carService = new CarService($carRepositoryMock, $uploadImageServiceMock);
        $carRequestMock = $this->getMockBuilder(CarRequest::class)->disableOriginalConstructor()->getMock();

        $this->expectException(UploadFileException::class);
        $_FILES['image'] = 'image';
        $cars = $carService->save($carRequestMock);
    }

    public function testAddCarFail()
    {
        $carRepositoryMock = $this->getMockBuilder(CarRepository::class)->disableOriginalConstructor()->getMock();
        $carRepositoryMock->expects($this->once())->method('findById')->willReturn(null);
        $uploadImageServiceMock = $this->getMockBuilder(UploadImageService::class)->disableOriginalConstructor()->getMock();
        $uploadImageServiceMock->expects($this->once())->method('upload')->willReturn("https://image.com/image.png");
        $carService = new CarService($carRepositoryMock, $uploadImageServiceMock);
        $carRequestMock = $this->getMockBuilder(CarRequest::class)->disableOriginalConstructor()->getMock();
        $_FILES['image'] = 'image';
        $car = $carService->save($carRequestMock);
        $this->assertNull($car);
    }

    public function testAddCarSuccess()
    {
        $carMock = $this->getCar(2, 'car1', 'descriptcar1', 'image', 2000);
        $carRepositoryMock = $this->getMockBuilder(CarRepository::class)->disableOriginalConstructor()->getMock();
        $carRepositoryMock->expects($this->once())->method('findById')->willReturn($carMock);
        $uploadImageServiceMock = $this->getMockBuilder(UploadImageService::class)->disableOriginalConstructor()->getMock();
        $uploadImageServiceMock->expects($this->once())->method('upload')->willReturn("https://image.com/image.png");
        $carService = new CarService($carRepositoryMock, $uploadImageServiceMock);
        $carRequestMock = $this->getMockBuilder(CarRequest::class)->disableOriginalConstructor()->getMock();
        $_FILES['image'] = 'image';
        $car = $carService->save($carRequestMock);
        $this->assertEquals($carMock->getId(), $car->getId());
        $this->assertEquals($carMock->getName(), $car->getName());
    }

    private function getCar(int $id, string $name, string $description, string $image, int $price): Car
    {
        $car = new Car();
        $car->setId($id);
        $car->setName($name);
        $car->setDescription($description);
        $car->setImage($image);
        $car->setPrice($price);

        return $car;
    }
}
