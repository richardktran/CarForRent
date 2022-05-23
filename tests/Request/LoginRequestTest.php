<?php

namespace Khoatran\Tests\Request;

use Khoatran\CarForRent\Exception\ValidationException;
use Khoatran\CarForRent\Request\LoginRequest;
use PHPUnit\Framework\TestCase;

class LoginRequestTest extends TestCase
{
    public function testGetUsername()
    {
        $userModel = new LoginRequest();
        $userModel->setUsername('admin');
        $result = $userModel->getUsername();

        $this->assertEquals('admin', $result);
    }

    public function testGetPassword()
    {
        $userModel = new LoginRequest();
        $userModel->setPassword('password');
        $result = $userModel->getPassword();

        $this->assertEquals('password', $result);
    }

    public function testFromArray()
    {
        $userModel = new LoginRequest();
        $userResult = $userModel->fromArray(['username' => 'admin', 'password' => 'password']);
        $this->assertEquals('admin', $userResult->getUsername());
        $this->assertEquals('password', $userResult->getPassword());
    }

    public function testValidationInputLoginRequestSuccess()
    {
        $userModel = new LoginRequest();
        $userModel->setUsername('admin');
        $userModel->setPassword('password');
        $result = $userModel->validate();
        $this->assertTrue($result);
    }

    public function testValidationInputLoginRequestFail()
    {
        $userModel = new LoginRequest();
        $userModel->setUsername('');
        $userModel->setPassword('');
        $this->expectException(ValidationException::class);
        $userModel->validate();
    }
}
