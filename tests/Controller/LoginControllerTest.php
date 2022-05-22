<?php

namespace Khoatran\Tests\Controller;

use Khoatran\CarForRent\Controller\LoginController;
use Khoatran\CarForRent\Exception\LoginException;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;
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
        $requestMock->expects($this->once())->method('getBody')->willReturn(['username' => 'admin', 'password' => '12345678']);
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();
        $loginServiceMock->expects($this->once())->method('login')->willReturn($this->user);

        $sessionServiceMock = $this->getMockBuilder(SessionServiceInterface::class)->disableOriginalConstructor()->getMock();

        $loginController = new LoginController($requestMock, $response, $loginServiceMock, $sessionServiceMock);
        $loginController = $loginController->login();

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
        $sessionServiceMock = $this->getMockBuilder(SessionServiceInterface::class)->disableOriginalConstructor()->getMock();

        $loginController = new LoginController($requestMock, $response, $loginServiceMock, $sessionServiceMock);
        $loginController = $loginController->login();

        $expectedResult = new Response();
        $expectedResult->setTemplate('login');

        $this->assertEquals($expectedResult->getTemplate(), $loginController->getTemplate());
    }

    public function testLoginActionWithLoginFail(): void
    {
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $requestMock->expects($this->once())->method('getBody')->willReturn(['username' => 'admin', 'password' => '12345678']);
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();
        $loginServiceMock->expects($this->once())->method('login')->willThrowException(new LoginException('Your username or password is not correct'));
        $sessionServiceMock = $this->getMockBuilder(SessionServiceInterface::class)->disableOriginalConstructor()->getMock();

        $loginController = new LoginController($requestMock, $response, $loginServiceMock, $sessionServiceMock);
        $loginController = $loginController->login();

        $expectedResult = new Response();
        $expectedResult->setTemplate('login');

        $this->assertEquals($expectedResult->getTemplate(), $loginController->getTemplate());
    }


}
