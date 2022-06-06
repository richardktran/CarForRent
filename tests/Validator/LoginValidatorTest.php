<?php

namespace Khoatran\Tests\Validator;

use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Validator\LoginValidator;
use PHPUnit\Framework\TestCase;

class LoginValidatorTest extends TestCase
{
    public function testValidateLoginSuccess()
    {
        $loginRequest = $this->getLoginRequest('admin', '123456');
        $loginValidator = new LoginValidator();
        $errors = $loginValidator->validateUserLogin($loginRequest);
        $this->assertEmpty($errors);
    }

    public function testValidateLoginFail()
    {
        $loginRequest = $this->getLoginRequest('a', '1');
        $loginValidator = new LoginValidator();
        $errors = $loginValidator->validateUserLogin($loginRequest);
        $this->assertNotEmpty($errors);
    }

    private function getLoginRequest(string $username, string $password): LoginRequest
    {
        $loginRequest = new LoginRequest();
        $loginRequest->setUsername($username);
        $loginRequest->setPassword($password);
        return $loginRequest;
    }
}
