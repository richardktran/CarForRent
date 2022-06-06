<?php

namespace Khoatran\Tests\Request;

use Khoatran\CarForRent\Request\RegisterRequest;
use PHPUnit\Framework\TestCase;

class RegisterRequestTest extends TestCase
{
    public function testGetUsername()
    {
        $registerModel = new RegisterRequest();
        $registerModel->setUsername('admin');
        $result = $registerModel->getUsername();

        $this->assertEquals('admin', $result);
    }

    public function testGetPassword()
    {
        $registerModel = new RegisterRequest();
        $registerModel->setPassword('password');
        $result = $registerModel->getPassword();

        $this->assertEquals('password', $result);
    }

    public function testGetConfirmPassword()
    {
        $registerModel = new RegisterRequest();
        $registerModel->setConfirmPassword('Confirm password');
        $result = $registerModel->getConfirmPassword();

        $this->assertEquals('Confirm password', $result);
    }

    public function testGetFullName()
    {
        $registerModel = new RegisterRequest();
        $registerModel->setFullName('Full name');
        $result = $registerModel->getFullName();

        $this->assertEquals('Full name', $result);
    }

    public function testGetPhoneNumber()
    {
        $registerModel = new RegisterRequest();
        $registerModel->setPhoneNumber('09484984844');
        $result = $registerModel->getPhoneNumber();

        $this->assertEquals('09484984844', $result);
    }

    public function testFromArray()
    {
        $registerModel = new RegisterRequest();
        $registerResult = $registerModel->fromArray([
            'username' => 'admin',
            'password' => 'password',
            'confirmPassword' => 'Confirm password',
            'fullName' => 'Full name',
            'phoneNumber' => '09484984844',
        ]);
        $this->assertEquals('admin', $registerResult->getUsername());
        $this->assertEquals('password', $registerResult->getPassword());
        $this->assertEquals('Confirm password', $registerResult->getConfirmPassword());
        $this->assertEquals('Full name', $registerResult->getFullName());
        $this->assertEquals('09484984844', $registerResult->getPhoneNumber());
    }
}
