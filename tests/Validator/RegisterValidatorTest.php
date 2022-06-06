<?php

namespace Khoatran\Tests\Validator;

use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\RegisterRequest;
use Khoatran\CarForRent\Validator\RegisterValidator;
use PHPUnit\Framework\TestCase;

class RegisterValidatorTest extends TestCase
{
    public function testValidateLoginSuccess()
    {
        $requestRequest = $this->getLoginRequest(
            'admin', '123456',
            '123456', 'Khoa',
            '0947484748'
        );
        $userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userRepository->expects($this->once())
            ->method('findByUsername')
            ->willReturn(null);
        $loginValidator = new RegisterValidator($userRepository);
        $errors = $loginValidator->validateUserRegister($requestRequest);
        $this->assertEmpty($errors);
    }

    public function testValidateLoginWithExistUser()
    {
        $requestRequest = $this->getLoginRequest(
            '1', '1',
            '123456', 'Khoa',
            '0947484748'
        );
        $userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userRepository->expects($this->once())
            ->method('findByUsername')
            ->willReturn(new UserModel());
        $loginValidator = new RegisterValidator($userRepository);
        $errors = $loginValidator->validateUserRegister($requestRequest);
        $this->assertEquals('Username already exists', $errors['username']);
    }

    public function testValidateLoginFail()
    {
        $requestRequest = $this->getLoginRequest(
            '1', '1',
            '', 'Khoa',
            '0947484748'
        );
        $userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userRepository->expects($this->once())
            ->method('findByUsername')
            ->willReturn(null);
        $loginValidator = new RegisterValidator($userRepository);
        $errors = $loginValidator->validateUserRegister($requestRequest);
        $this->assertNotEmpty($errors);
    }

    public function testValidateLoginConfirmPasswordNotMatch()
    {
        $requestRequest = $this->getLoginRequest(
            '1', '1',
            '2', 'Khoa',
            '0947484748'
        );
        $userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userRepository->expects($this->once())
            ->method('findByUsername')
            ->willReturn(null);
        $loginValidator = new RegisterValidator($userRepository);
        $errors = $loginValidator->validateUserRegister($requestRequest);
        $this->assertNotEmpty($errors);
    }

    private function getLoginRequest(
        string $username,
        string $password,
        string $confirmPassword,
        string $fullName,
        string $phoneNumber
    ): RegisterRequest {
        $requestRequest = new RegisterRequest();
        $requestRequest->setUsername($username);
        $requestRequest->setPassword($password);
        $requestRequest->setConfirmPassword($confirmPassword);
        $requestRequest->setFullName($fullName);
        $requestRequest->setPhoneNumber($phoneNumber);
        return $requestRequest;
    }
}
