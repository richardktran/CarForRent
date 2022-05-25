<?php

namespace Khoatran\Tests\Service\Business;

use Khoatran\CarForRent\Exception\LoginException;
use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Service\Business\LoginService;
use PHPUnit\Framework\TestCase;

class LoginServiceTest extends TestCase
{

    /**
     * @dataProvider loginSuccessProvider
     * @param array $params
     * @param array $expected
     * @return void
     * @throws LoginException
     */
    public function testLoginSuccess(array $params, array $expected): void
    {
        $loginRequest = new LoginRequest();
        $loginRequest->fromArray($params);
        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $userRepositoryMock->expects($this->once())->method('findByUsername')->willReturn($params['userReturn']);

        $loginService = new LoginService($userRepositoryMock);
        $userResult = $loginService->login($loginRequest);
        $expectedUser = $expected['user'];
        $this->assertEquals($expectedUser->getUsername(), $userResult->getUsername());
        $this->assertEquals($expectedUser->getId(), $userResult->getId());
    }


    /**
     * @dataProvider loginWrongPasswordProvider
     * @param array $params
     * @param array $expected
     * @return void
     * @throws LoginException
     */
    public function testLoginFailWithWrongPassword(array $params, array $expected): void
    {
        $loginRequest = new LoginRequest();
        $loginRequest->fromArray($params);
        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $userRepositoryMock->expects($this->once())->method('findByUsername')->willReturn($expected['user']);

        $loginService = new LoginService($userRepositoryMock);
        $isLogin = $loginService->login($loginRequest);
        $this->assertNull($isLogin);
    }

    /**
     * @dataProvider loginWrongPasswordProvider
     * @param array $params
     * @param array $expected
     * @return void
     */
    public function testLoginFailWithAccountNotInDatabase(array $params, array $expected): void
    {
        $loginRequest = new LoginRequest();
        $loginRequest->fromArray($params);
        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $userRepositoryMock->expects($this->once())->method('findByUsername')->willReturn(null);

        $loginService = new LoginService($userRepositoryMock);
        $isLogin = $loginService->login($loginRequest);
        $this->assertNull($isLogin);
    }

    public function loginSuccessProvider()
    {
        return [
            'happy-case-1' => [
                'params' => [
                    'username' => 'admin',
                    'password' => '12345678',
                    'userReturn' => $this->getUser(1, 'admin', $this->hashPassword('12345678')),
                ],
                'expected' => [
                    'user' => $this->getUser(1, 'admin', $this->hashPassword('12345678'))
                ]
            ],
            'happy-case-2' => [
                'params' => [
                    'username' => 'khoa',
                    'password' => '123456',
                    'userReturn' => $this->getUser(2, 'khoa', $this->hashPassword('123456')),
                ],
                'expected' => [
                    'user' => $this->getUser(2, 'khoa', $this->hashPassword('123456'))
                ]
            ]
        ];
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private function getUser(int $id, string $username, string $password): UserModel
    {
        $user = new UserModel();
        $user->setId($id);
        $user->setUsername($username);
        $user->setPassword($password);

        return $user;
    }

    public function loginWrongPasswordProvider()
    {
        return [
            'wrong-password-case-1' => [
                'params' => [
                    'username' => 'admin',
                    'password' => '1234567',
                ],
                'expected' => [
                    'user' => $this->getUser(1, 'admin', $this->hashPassword('12345678'))
                ]
            ],
            'wrong-password-case-2' => [
                'params' => [
                    'username' => 'khoa',
                    'password' => '12345678',
                ],
                'expected' => [
                    'user' => $this->getUser(2, 'khoa', $this->hashPassword('123456'))
                ]
            ]
        ];
    }
}
