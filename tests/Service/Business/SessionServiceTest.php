<?php

namespace Khoatran\Tests\Service\Business;

use Khoatran\CarForRent\Model\SessionModel;
use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Repository\SessionRepository;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Service\Business\SessionService;
use PHPUnit\Framework\TestCase;

class SessionServiceTest extends TestCase
{
    public function testGetUserIdFromSessionsSuccess()
    {
        $sessionModel = $this->getSession('dfsafads11dsfad', '1', 60 * 60 * 24);
        $sessionRepositoryMock = $this->getMockBuilder(SessionRepository::class)->disableOriginalConstructor()->getMock();
        $sessionRepositoryMock->expects($this->once())->method('findById')->willReturn($sessionModel);
        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $user = $this->getUser(1, 'user1', 'password');
        $userRepositoryMock->expects($this->once())->method('findById')->willReturn($user);
        $session = new SessionService($sessionRepositoryMock, $userRepositoryMock);
        $userIdResult = $session->getUserToken();
        $this->assertEquals(1, $userIdResult);
    }

    public function testGetUserIdFromSessionsFail()
    {
        $sessionModel = new SessionModel();
        $sessionRepositoryMock = $this->getMockBuilder(SessionRepository::class)->disableOriginalConstructor()->getMock();
        $sessionRepositoryMock->expects($this->once())->method('findById')->willReturn($sessionModel);
        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $session = new SessionService($sessionRepositoryMock, $userRepositoryMock);
        $userIdResult = $session->getUserToken();
        $this->assertEquals(null, $userIdResult);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSetUserIdFromSessionsSuccess()
    {
        $sessionModel = $this->getSession('dfsafads11dsfad', '1', 60 * 60 * 24);
        $sessionRepositoryMock = $this->getMockBuilder(SessionRepository::class)->disableOriginalConstructor()->getMock();
        $sessionRepositoryMock->expects($this->once())->method('save')->willReturn($sessionModel);
        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $session = new SessionService($sessionRepositoryMock, $userRepositoryMock);
        $setResult = $session->setUserToken(1);
        $this->assertTrue($setResult);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSetUserIdFromSessionsFail()
    {
        $sessionRepositoryMock = $this->getMockBuilder(SessionRepository::class)->disableOriginalConstructor()->getMock();
        $sessionRepositoryMock->expects($this->once())->method('save')->willReturn(false);
        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $session = new SessionService($sessionRepositoryMock, $userRepositoryMock);
        $setResult = $session->setUserToken(1);
        $this->assertFalse($setResult);
    }

    /**
     * @runInSeparateProcess
     */
    public function testDestroyUserFromSessionsSuccess()
    {
        $sessionRepositoryMock = $this->getMockBuilder(SessionRepository::class)->disableOriginalConstructor()->getMock();
        $sessionRepositoryMock->expects($this->once())->method('deleteById')->willReturn(true);
        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $session = new SessionService($sessionRepositoryMock, $userRepositoryMock);
        $destroyResult = $session->destroyUser();
        $this->assertTrue($destroyResult);
    }

    /**
     * @runInSeparateProcess
     */
    public function testDestroyUserFromSessionsFail()
    {
        $sessionRepositoryMock = $this->getMockBuilder(SessionRepository::class)->disableOriginalConstructor()->getMock();
        $sessionRepositoryMock->expects($this->once())->method('deleteById')->willReturn(false);
        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $session = new SessionService($sessionRepositoryMock, $userRepositoryMock);
        $destroyResult = $session->destroyUser();
        $this->assertFalse($destroyResult);
    }

    public function testUserIsLogin()
    {
        $sessionServiceMock = $this->getMockBuilder(SessionService::class)->onlyMethods(['getUserToken'])->disableOriginalConstructor()->getMock();
        $sessionServiceMock->method('getUserToken')->willReturn(1);
        $isLoginResult = $sessionServiceMock->isLogin();
        $this->assertTrue($isLoginResult);

    }

    private function getSession(string $id, string $data, int $lifeTime): SessionModel
    {
        $sessionModel = new SessionModel();
        $sessionModel->setSessID($id);
        $sessionModel->setSessData($data);
        $sessionModel->setSessLifetime($lifeTime);
        return $sessionModel;
    }

    private function getUser(int $id, string $username, string $password): UserModel
    {
        $user = new UserModel();
        $user->setId($id);
        $user->setUsername($username);
        $user->setPassword($password);

        return $user;
    }
}
