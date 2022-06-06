<?php

namespace Khoatran\Tests\Controller;

use Khoatran\CarForRent\Controller\LoginController;
use Khoatran\CarForRent\Exception\LoginException;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Service\Business\SessionService;
use Khoatran\CarForRent\Service\Business\TokenService;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;
use Khoatran\CarForRent\Validator\LoginValidator;
use PHPUnit\Framework\TestCase;

class LoginControllerTest extends TestCase
{
    protected UserModel $user;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->user = new UserModel();
        $this->user->setId(1);
        $this->user->setUsername('admin');
        $this->user->setPassword('12345678');
    }

    public function testLoginActionSuccess(): void
    {
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $requestMock->expects($this->once())->method('getBody')->willReturn([
            'username' => 'admin',
            'password' => '12345678'
        ]);
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();
        $loginServiceMock->expects($this->once())->method('login')->willReturn($this->user);

        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $tokenServiceMock = $this->getMockBuilder(TokenService::class)->disableOriginalConstructor()->getMock();
        $loginRequestMock = $this->getMockBuilder(LoginRequest::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock = $this->getMockBuilder(LoginValidator::class)->disableOriginalConstructor()->getMock();

        $loginController = new LoginController($requestMock, $response, $loginServiceMock, $sessionServiceMock, $tokenServiceMock);
        $loginController = $loginController->login($loginRequestMock, $loginValidatorMock);

        $expectedResult = new Response();
        $expectedResult->setRedirectUrl('/');

        $this->assertEquals($expectedResult, $loginController);
    }

    public function testLoginActionWithInvalidationBody(): void
    {
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $requestMock->expects($this->once())->method('getBody')->willReturn(['username' => '', 'password' => '']);
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();

        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $tokenServiceMock = $this->getMockBuilder(TokenService::class)->disableOriginalConstructor()->getMock();
        $loginRequestMock = $this->getMockBuilder(LoginRequest::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock = $this->getMockBuilder(LoginValidator::class)->disableOriginalConstructor()->getMock();

        $loginController = new LoginController($requestMock, $response, $loginServiceMock, $sessionServiceMock, $tokenServiceMock);
        $loginController = $loginController->login($loginRequestMock, $loginValidatorMock);

        $expectedResult = new Response();
        $expectedResult->setTemplate('login');

        $this->assertEquals($expectedResult->getTemplate(), $loginController->getTemplate());
    }

    public function testLoginActionWithLoginFail(): void
    {
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $requestMock->expects($this->once())->method('getBody')->willReturn([
            'username' => 'admin',
            'password' => '12345678'
        ]);
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();
        $loginServiceMock->expects($this->once())->method('login')->willReturn(null);

        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $tokenServiceMock = $this->getMockBuilder(TokenService::class)->disableOriginalConstructor()->getMock();
        $loginRequestMock = $this->getMockBuilder(LoginRequest::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock = $this->getMockBuilder(LoginValidator::class)->disableOriginalConstructor()->getMock();

        $loginController = new LoginController($requestMock, $response, $loginServiceMock, $sessionServiceMock, $tokenServiceMock);
        $loginController = $loginController->login($loginRequestMock, $loginValidatorMock);

        $expectedResult = new Response();
        $expectedResult->setTemplate('login');

        $this->assertEquals($expectedResult->getTemplate(), $loginController->getTemplate());
    }

    public function testLoginActionWithValidateFail(): void
    {
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $requestMock->expects($this->once())->method('getBody')->willReturn([
            'username' => 'admin',
            'password' => '12345678'
        ]);
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();

        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $tokenServiceMock = $this->getMockBuilder(TokenService::class)->disableOriginalConstructor()->getMock();
        $loginRequestMock = $this->getMockBuilder(LoginRequest::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock = $this->getMockBuilder(LoginValidator::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock->expects($this->once())->method('validateUserLogin')->willReturn([
            'username' => 'Username invalid',
            'password' => 'Password invalid'
        ]);

        $loginController = new LoginController($requestMock, $response, $loginServiceMock, $sessionServiceMock, $tokenServiceMock);
        $loginController = $loginController->login($loginRequestMock, $loginValidatorMock);

        $expectedResult = new Response();
        $expectedResult->setTemplate('login');

        $this->assertEquals($expectedResult->getTemplate(), $loginController->getTemplate());
    }


    public function testLoginViewWithoutSession(): void
    {
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $request->expects($this->once())->method('isGet')->willReturn(true);
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock->expects($this->once())->method('isLogin')->willReturn(false);

        $tokenServiceMock = $this->getMockBuilder(TokenService::class)->disableOriginalConstructor()->getMock();
        $loginRequestMock = $this->getMockBuilder(LoginRequest::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock = $this->getMockBuilder(LoginValidator::class)->disableOriginalConstructor()->getMock();

        $loginController = new LoginController($request, $response, $loginServiceMock, $sessionServiceMock, $tokenServiceMock);
        $loginController = $loginController->login($loginRequestMock, $loginValidatorMock);

        $expectedResult = new Response();
        $expectedResult->setTemplate('login');
        $expectedResult->setStatusCode(200);
        $expectedResult->setData([
            'username' => '',
            'password' => '',
        ]);

        $this->assertEquals($expectedResult, $loginController);
    }

    public function testLoginViewWithSessionExist(): void
    {
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $request->expects($this->once())->method('isGet')->willReturn(true);
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock->expects($this->once())->method('isLogin')->willReturn(true);

        $tokenServiceMock = $this->getMockBuilder(TokenService::class)->disableOriginalConstructor()->getMock();
        $loginRequestMock = $this->getMockBuilder(LoginRequest::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock = $this->getMockBuilder(LoginValidator::class)->disableOriginalConstructor()->getMock();

        $loginController = new LoginController($request, $response, $loginServiceMock, $sessionServiceMock, $tokenServiceMock);
        $loginController = $loginController->login($loginRequestMock, $loginValidatorMock);

        $expectedResult = new Response();
        $expectedResult->setRedirectUrl('/');

        $this->assertEquals($expectedResult, $loginController);
    }

    public function testLogoutSuccess(): void
    {
        $request = new Request();
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock->expects($this->once())->method('destroyUser')->willReturn(true);
        $tokenServiceMock = $this->getMockBuilder(TokenService::class)->disableOriginalConstructor()->getMock();
        $loginController = new LoginController($request, $response, $loginServiceMock, $sessionServiceMock, $tokenServiceMock);
        $loginController = $loginController->logout();

        $expectedResult = new Response();
        $expectedResult->setRedirectUrl('/');

        $this->assertEquals($expectedResult, $loginController);
    }

    public function testLogoutFail(): void
    {
        $request = new Request();
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->disableOriginalConstructor()->getMock();
        $sessionServiceMock->expects($this->once())->method('destroyUser')->willReturn(false);
        $tokenServiceMock = $this->getMockBuilder(TokenService::class)->disableOriginalConstructor()->getMock();
        $loginController = new LoginController($request, $response, $loginServiceMock, $sessionServiceMock, $tokenServiceMock);
        $loginController = $loginController->logout();

        $expectedResult = new Response();
        $expectedResult->setRedirectUrl('/');

        $this->assertEquals($expectedResult, $loginController);
    }


}
