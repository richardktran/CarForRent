<?php

namespace Khoatran\Tests\Model;

use Khoatran\CarForRent\Model\Car;
use Khoatran\CarForRent\Model\User;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    public function testGetId()
    {
        $carModel = new Car();
        $carModel->setId(1);
        $result = $carModel->getId();

        $this->assertEquals(1, $result);
    }

    public function testGetName()
    {
        $carModel = new Car();
        $carModel->setName("KIA");
        $result = $carModel->getName();

        $this->assertEquals("KIA", $result);
    }

    public function testGetDescription()
    {
        $carModel = new Car();
        $carModel->setDescription("Description");
        $result = $carModel->getDescription();

        $this->assertEquals("Description", $result);
    }

    public function testGetType()
    {
        $carModel = new Car();
        $carModel->setType("Type");
        $result = $carModel->getType();

        $this->assertEquals("Type", $result);
    }

    public function testGetImage()
    {
        $carModel = new Car();
        $carModel->setImage("https://image.com/image.jpg");
        $result = $carModel->getImage();

        $this->assertEquals("https://image.com/image.jpg", $result);
    }

    public function testGetPrice()
    {
        $carModel = new Car();
        $carModel->setPrice(23);
        $result = $carModel->getPrice();

        $this->assertEquals(23, $result);
    }

    public function testGetBrand()
    {
        $carModel = new Car();
        $carModel->setBrand("Brand");
        $result = $carModel->getBrand();

        $this->assertEquals("Brand", $result);
    }

    public function testGetProductionYear()
    {
        $carModel = new Car();
        $carModel->setProductionYear("2022");
        $result = $carModel->getProductionYear();

        $this->assertEquals("2022", $result);
    }

    public function testGetOwnerId()
    {
        $carModel = new Car();
        $carModel->setOwnerId(23);
        $result = $carModel->getOwnerId();

        $this->assertEquals(23, $result);
    }
}
