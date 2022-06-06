<?php

namespace Khoatran\Tests\Controller;

use Khoatran\CarForRent\Controller\CarController;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Model\CarModel;
use Khoatran\CarForRent\Request\CarRequest;
use Khoatran\CarForRent\Service\Business\CarService;
use Khoatran\CarForRent\Service\Business\SessionService;
use Khoatran\CarForRent\Transformer\CarTransformer;
use Khoatran\CarForRent\Validator\CarValidator;
use PHPUnit\Framework\TestCase;

class CarControllerTest extends TestCase
{
    public function testGetAllCarSuccess()
    {
        $requestMock = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $response = new Response();
        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $carTransformerMock = $this->getMockBuilder(CarTransformer::class)->disableOriginalConstructor()->getMock();
        $carServiceMock = $this->getMockBuilder(CarService::class)->disableOriginalConstructor()->getMock();

        $carArray = [
            $this->getCar(2, 'car1', 'descriptcar1', 'image', 2000),
            $this->getCar(3, 'car2', 'descriptcar2', 'image', 3000),
        ];
        $carServiceMock->expects($this->once())->method('getAll')->willReturn($carArray);

        $carController = new CarController(
            $requestMock, $response, $sessionServiceMock, $carServiceMock,
            $carTransformerMock
        );
        $response = $carController->index();

        $responseExpected = new Response();
        $responseExpected->setTemplate('home');
        $this->assertEquals($responseExpected->getTemplate(), $response->getTemplate());
    }

    public function testRenderViewCreateCar()
    {
        $requestMock = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $requestMock->expects($this->once())->method('isGet')->willReturn(true);
        $response = new Response();
        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $carTransformerMock = $this->getMockBuilder(CarTransformer::class)->disableOriginalConstructor()->getMock();
        $carServiceMock = $this->getMockBuilder(CarService::class)->disableOriginalConstructor()->getMock();

        $carRequestMock = $this->getMockBuilder(CarRequest::class)->disableOriginalConstructor()->getMock();
        $carValidatorMock = $this->getMockBuilder(CarValidator::class)->disableOriginalConstructor()->getMock();

        $carController = new CarController(
            $requestMock, $response, $sessionServiceMock, $carServiceMock,
            $carTransformerMock
        );
        $response = $carController->store($carRequestMock, $carValidatorMock);

        $responseExpected = new Response();
        $responseExpected->setTemplate('create_car');


        $this->assertEquals($responseExpected->getTemplate(), $response->getTemplate());
        $this->assertNull($response->getData());
    }

    public function testAddCarWithUnValid()
    {
        $requestMock = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $requestMock->expects($this->once())->method('isGet')->willReturn(false);
        $response = new Response();
        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $carTransformerMock = $this->getMockBuilder(CarTransformer::class)->disableOriginalConstructor()->getMock();
        $carServiceMock = $this->getMockBuilder(CarService::class)->disableOriginalConstructor()->getMock();

        $carRequestMock = $this->getMockBuilder(CarRequest::class)->disableOriginalConstructor()->getMock();
        $carValidatorMock = $this->getMockBuilder(CarValidator::class)->disableOriginalConstructor()->getMock();
        $carValidatorMock->expects($this->once())->method('validateCar')->willReturn([
            'name' => 'Invalid name',
            'description' => 'Invalid description',
        ]);

        $carController = new CarController(
            $requestMock, $response, $sessionServiceMock, $carServiceMock,
            $carTransformerMock
        );
        $response = $carController->store($carRequestMock, $carValidatorMock);

        $responseExpected = new Response();
        $responseExpected->setTemplate('create_car');

        $this->assertEquals($responseExpected->getTemplate(), $response->getTemplate());
        $this->assertEquals(false, array_key_exists('success', $response->getData()));
    }

    public function testAddCarWithValid()
    {
        $requestMock = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $requestMock->expects($this->once())->method('isGet')->willReturn(false);
        $response = new Response();
        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $carTransformerMock = $this->getMockBuilder(CarTransformer::class)->disableOriginalConstructor()->getMock();
        $carServiceMock = $this->getMockBuilder(CarService::class)->disableOriginalConstructor()->getMock();

        $carRequestMock = $this->getMockBuilder(CarRequest::class)->disableOriginalConstructor()->getMock();
        $carValidatorMock = $this->getMockBuilder(CarValidator::class)->disableOriginalConstructor()->getMock();
        $carValidatorMock->expects($this->once())->method('validateCar')->willReturn([]);

        $carController = new CarController(
            $requestMock, $response, $sessionServiceMock, $carServiceMock,
            $carTransformerMock
        );
        $response = $carController->store($carRequestMock, $carValidatorMock);

        $responseExpected = new Response();
        $responseExpected->setTemplate('create_car');

        $this->assertEquals($responseExpected->getTemplate(), $response->getTemplate());
        $this->assertEquals(true, array_key_exists('success', $response->getData()));
    }

    private function getCar(int $id, string $name, string $description, string $image, int $price): CarModel
    {
        $car = new CarModel();
        $car->setId($id);
        $car->setName($name);
        $car->setDescription($description);
        $car->setImage($image);
        $car->setPrice($price);

        return $car;
    }
}
