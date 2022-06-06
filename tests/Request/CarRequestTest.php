<?php

namespace Khoatran\Tests\Request;

use Khoatran\CarForRent\Request\CarRequest;
use Khoatran\CarForRent\Request\LoginRequest;
use PHPUnit\Framework\TestCase;

class CarRequestTest extends TestCase
{
    public function testGetName()
    {
        $carRequest = new CarRequest();
        $carRequest->setName('Kia');
        $result = $carRequest->getName();

        $this->assertEquals('Kia', $result);
    }

    public function testGetDescription()
    {
        $carRequest = new CarRequest();
        $carRequest->setDescription('Car description');
        $result = $carRequest->getDescription();

        $this->assertEquals('Car description', $result);
    }

    public function testGetType()
    {
        $carRequest = new CarRequest();
        $carRequest->setType('Car type');
        $result = $carRequest->getType();

        $this->assertEquals('Car type', $result);
    }

    public function testGetImage()
    {
        $carRequest = new CarRequest();
        $carRequest->setImage('Car image');
        $result = $carRequest->getImage();

        $this->assertEquals('Car image', $result);
    }

    public function testGetPrice()
    {
        $carRequest = new CarRequest();
        $carRequest->setPrice(1);
        $result = $carRequest->getPrice();

        $this->assertEquals(1, $result);

        $carRequest->setPrice(null);
        $result = $carRequest->getPrice();

        $this->assertEquals(0, $result);
    }

    public function testGetBrand()
    {
        $carRequest = new CarRequest();
        $carRequest->setBrand('Car brand');
        $result = $carRequest->getBrand();

        $this->assertEquals('Car brand', $result);
    }

    public function testGetProductionYear()
    {
        $carRequest = new CarRequest();
        $carRequest->setProductionYear('2022');
        $result = $carRequest->getProductionYear();

        $this->assertEquals('2022', $result);

        $carRequest->setProductionYear(null);
        $result = $carRequest->getProductionYear();

        $this->assertEquals(2022, $result);
    }

    public function testGetOwnerId()
    {
        $carRequest = new CarRequest();
        $carRequest->setOwnerId(1);
        $result = $carRequest->getOwnerId();

        $this->assertEquals(1, $result);
    }

    public function testFromArray()
    {
        $carRequest = new CarRequest();
        $carRequest = $carRequest->fromArray([
            'name' => 'Kia',
            'description' => 'car description',
            'type' => 'car type',
            'image' => 'car image',
            'price' => 1,
            'brand' => 'car brand',
            'production_year' => '2022',
            'owner_id' => 1,
        ]);
        $this->assertEquals('Kia', $carRequest->getName());
        $this->assertEquals('car description', $carRequest->getDescription());
        $this->assertEquals('car type', $carRequest->getType());
        $this->assertEquals('car image', $carRequest->getImage());
        $this->assertEquals(1, $carRequest->getPrice());
        $this->assertEquals('car brand', $carRequest->getBrand());
        $this->assertEquals('2022', $carRequest->getProductionYear());
        $this->assertEquals(1, $carRequest->getOwnerId());
    }

}
