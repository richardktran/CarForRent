<?php

namespace Khoatran\Tests\Controller\API;

use Khoatran\CarForRent\Controller\API\CarAPIController;
use Khoatran\CarForRent\Controller\CarController;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Model\Car;
use Khoatran\CarForRent\Service\Business\CarService;
use Khoatran\CarForRent\Service\Business\SessionService;
use Khoatran\CarForRent\Transformer\CarTransformer;
use PHPUnit\Framework\TestCase;

class CarAPIControllerTest extends TestCase
{
    public function testGetAllCarSuccess()
    {
        $requestMock = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $response = new Response();
        $carTransformerMock = $this->getMockBuilder(CarTransformer::class)->disableOriginalConstructor()->getMock();
        $carServiceMock = $this->getMockBuilder(CarService::class)->disableOriginalConstructor()->getMock();

        $carArray = [
            $this->getCar(2, 'car1', 'descriptcar1', 'image', 2000),
            $this->getCar(3, 'car2', 'descriptcar2', 'image', 3000),
        ];
        $carServiceMock->expects($this->once())->method('getAll')->willReturn($carArray);

        $carController = new CarAPIController($requestMock, $response, $carServiceMock, $carTransformerMock);
        $response = $carController->listCars();

        $this->assertEquals(2, count($response->getData()['data']));
        $this->assertEquals(200, $response->getStatusCode());
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
