<?php

namespace Khoatran\Tests\Repository;

use Khoatran\CarForRent\Model\SessionModel;
use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Repository\SessionRepository;
use Khoatran\CarForRent\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class SessionRepositoryTest extends TestCase
{
    public function testFindByIdSuccess()
    {
        $session = new SessionModel();
        $sessionRepository = new SessionRepository();
        $session->setSessID(uniqid());
        $session->setSessData("1");
        $session->setSessLifetime(time() + (60 * 60 * 24));
        $sessionRepository->save($session);

        $result = $sessionRepository->findById($session->getSessID());
        $this->assertEquals($session->getSessID(), $result->getSessID());
        $this->assertEquals($session->getSessData(), $result->getSessData());

        $sessionRepository->deleteById($session->getSessID());
        $result = $sessionRepository->findById($session->getSessID());
        $this->assertNull($result->getSessID());
    }

    public function testFindByIdNotFound()
    {
        $sessionRepository = new SessionRepository();
        $result = $sessionRepository->findById('findbysessidnotfound');
        self::assertNull($result->getSessID());
    }
}
