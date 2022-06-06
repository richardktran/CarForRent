<?php

namespace Khoatran\Tests\Controller\API;

use Khoatran\CarForRent\Controller\API\LoginAPIController;
use Khoatran\CarForRent\Controller\LoginController;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Service\Business\SessionService;
use Khoatran\CarForRent\Service\Business\TokenService;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;
use Khoatran\CarForRent\Transformer\UserTransformer;
use Khoatran\CarForRent\Validator\LoginValidator;
use PHPUnit\Framework\TestCase;

class LoginAPIControllerTest extends TestCase
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
        $requestMock->expects($this->once())->method('getRequestJsonBody')->willReturn([
            'username' => 'admin',
            'password' => '12345678'
        ]);
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();
        $loginServiceMock->expects($this->once())->method('login')->willReturn($this->user);

        $userTransformerMock = $this->getMockBuilder(UserTransformer::class)->disableOriginalConstructor()->getMock();

        $tokenServiceMock = $this->getMockBuilder(TokenService::class)->disableOriginalConstructor()->getMock();
        $loginRequestMock = $this->getMockBuilder(LoginRequest::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock = $this->getMockBuilder(LoginValidator::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock->expects($this->once())->method('validateUserLogin')->willReturn([]);

        $loginController = new LoginAPIController($requestMock, $response, $loginServiceMock, $userTransformerMock,
            $tokenServiceMock);
        $loginController = $loginController->login($loginRequestMock, $loginValidatorMock);


        $this->assertEquals(200, $loginController->getStatusCode());
    }

    public function testLoginActionInvalid(): void
    {
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $requestMock->expects($this->once())->method('getRequestJsonBody')->willReturn([
            'username' => 'admin',
            'password' => '12345678'
        ]);
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();

        $userTransformerMock = $this->getMockBuilder(UserTransformer::class)->disableOriginalConstructor()->getMock();

        $tokenServiceMock = $this->getMockBuilder(TokenService::class)->disableOriginalConstructor()->getMock();
        $loginRequestMock = $this->getMockBuilder(LoginRequest::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock = $this->getMockBuilder(LoginValidator::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock->expects($this->once())->method('validateUserLogin')->willReturn([
            'username' => 'Username invalid',
            'password' => 'Password invalid'
        ]);

        $loginController = new LoginAPIController($requestMock, $response, $loginServiceMock, $userTransformerMock,
            $tokenServiceMock);
        $loginController = $loginController->login($loginRequestMock, $loginValidatorMock);


        $this->assertEquals(400, $loginController->getStatusCode());
    }

    public function testLoginActionFail(): void
    {
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $requestMock->expects($this->once())->method('getRequestJsonBody')->willReturn([
            'username' => 'admin',
            'password' => '12345678'
        ]);
        $response = new Response();
        $loginServiceMock = $this->getMockBuilder(LoginServiceInterface::class)->disableOriginalConstructor()->getMock();
        $loginServiceMock->expects($this->once())->method('login')->willReturn(null);

        $userTransformerMock = $this->getMockBuilder(UserTransformer::class)->disableOriginalConstructor()->getMock();

        $tokenServiceMock = $this->getMockBuilder(TokenService::class)->disableOriginalConstructor()->getMock();
        $loginRequestMock = $this->getMockBuilder(LoginRequest::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock = $this->getMockBuilder(LoginValidator::class)->disableOriginalConstructor()->getMock();
        $loginValidatorMock->expects($this->once())->method('validateUserLogin')->willReturn([]);

        $loginController = new LoginAPIController($requestMock, $response, $loginServiceMock, $userTransformerMock,
            $tokenServiceMock);
        $loginController = $loginController->login($loginRequestMock, $loginValidatorMock);


        $this->assertEquals(401, $loginController->getStatusCode());
    }
}
