<?php

namespace Khoatran\Tests\Controller;

use Khoatran\CarForRent\Controller\LoginController;
use Khoatran\CarForRent\Controller\RegisterController;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Request\RegisterRequest;
use Khoatran\CarForRent\Service\Business\RegisterService;
use Khoatran\CarForRent\Service\Business\SessionService;
use Khoatran\CarForRent\Service\Business\TokenService;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;
use Khoatran\CarForRent\Validator\LoginValidator;
use Khoatran\CarForRent\Validator\RegisterValidator;
use PHPUnit\Framework\TestCase;

class RegisterControllerTest extends TestCase
{
    public function testLoginActionSuccess(): void
    {
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $requestMock->expects($this->once())->method('getBody')->willReturn([
            'username' => 'admin',
            'password' => '12345678'
        ]);
        $response = new Response();

        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $registerRequestMock = $this->getMockBuilder(RegisterRequest::class)->disableOriginalConstructor()->getMock();
        $registerValidatorMock = $this->getMockBuilder(RegisterValidator::class)->disableOriginalConstructor()->getMock();

        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();

        $registerController = new RegisterController($requestMock, $response, $sessionServiceMock, $userRepositoryMock);
        $registerController = $registerController->register($registerRequestMock, $registerValidatorMock);

        $expectedResult = new Response();
        $expectedResult->setRedirectUrl('/login');

        $this->assertEquals($expectedResult, $registerController);
    }

    public function testRegisterActionWithValidateFail(): void
    {
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $requestMock->expects($this->once())->method('getBody')->willReturn([
            'username' => 'admin',
            'password' => '12345678'
        ]);
        $response = new Response();

        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $registerRequestMock = $this->getMockBuilder(RegisterRequest::class)->disableOriginalConstructor()->getMock();
        $registerValidatorMock = $this->getMockBuilder(RegisterValidator::class)->disableOriginalConstructor()->getMock();
        $registerValidatorMock->expects($this->once())->method('validateUserRegister')->willReturn([
            'username' => 'username invalid',
            'password' => 'password invalid'
        ]);

        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();

        $registerController = new RegisterController($requestMock, $response, $sessionServiceMock, $userRepositoryMock);
        $registerController = $registerController->register($registerRequestMock, $registerValidatorMock);

        $expectedResult = new Response();
        $expectedResult->setTemplate('register');

        $this->assertEquals($expectedResult->getTemplate(), $registerController->getTemplate());
    }

    public function testRegisterViewWithNoLogin(): void
    {
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $requestMock->expects($this->once())->method('isGet')->willReturn(true);
        $response = new Response();

        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $registerRequestMock = $this->getMockBuilder(RegisterRequest::class)->disableOriginalConstructor()->getMock();
        $registerValidatorMock = $this->getMockBuilder(RegisterValidator::class)->disableOriginalConstructor()->getMock();

        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();

        $registerController = new RegisterController($requestMock, $response, $sessionServiceMock, $userRepositoryMock);
        $registerController = $registerController->register($registerRequestMock, $registerValidatorMock);

        $expectedResult = new Response();
        $expectedResult->setTemplate('register');

        $this->assertEquals($expectedResult->getTemplate(), $registerController->getTemplate());
    }

    public function testRegisterViewWithLogin(): void
    {
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $requestMock->expects($this->once())->method('isGet')->willReturn(true);
        $response = new Response();

        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock->expects($this->once())->method('isLogin')->willReturn(true);
        $registerRequestMock = $this->getMockBuilder(RegisterRequest::class)->disableOriginalConstructor()->getMock();
        $registerValidatorMock = $this->getMockBuilder(RegisterValidator::class)->disableOriginalConstructor()->getMock();

        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();

        $registerController = new RegisterController($requestMock, $response, $sessionServiceMock, $userRepositoryMock);
        $registerController = $registerController->register($registerRequestMock, $registerValidatorMock);

        $expectedResult = new Response();
        $expectedResult->setRedirectUrl('/');

        $this->assertEquals($expectedResult, $registerController);
    }
}
