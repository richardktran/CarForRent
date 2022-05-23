<?php

namespace Khoatran\Tests\Service\Business;

use Khoatran\CarForRent\Model\SessionModel;
use Khoatran\CarForRent\Repository\SessionRepository;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Service\Business\SessionService;
use PHPUnit\Framework\TestCase;

class SessionServiceTest extends TestCase
{
    public function testGetUserIdFromSessionsSuccess()
    {
        $sessionModel = new SessionModel();
        $sessionModel->setSessID('1334sdfs4fds324sed');
        $sessionModel->setSessData('1');
        $sessionModel->setSessLifetime(60 * 60 * 24);
        $sessionRepositoryMock = $this->getMockBuilder(SessionRepository::class)->disableOriginalConstructor()->getMock();
        $sessionRepositoryMock->expects($this->once())->method('findById')->willReturn($sessionModel);
        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $userRepositoryMock->expects($this->once())->method('findById')->willReturn()
        $session = new SessionService($sessionRepositoryMock, $userRepositoryMock);
    }
}
