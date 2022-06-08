<?php

namespace Khoatran\Tests\Repository;

use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Model\User;
use Khoatran\CarForRent\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    public function testFindByUsernameSuccess()
    {
        $userModel = new User();
        $userRepository = new UserRepository($userModel);
        $userReturn = $userRepository->findByUsername('richardktran');
        $this->assertEquals('richardktran', $userReturn->getUsername());
    }

    public function testFindByUsernameFail()
    {
        $userModel = new User();
        $userRepository = new UserRepository($userModel);
        $userReturn = $userRepository->findByUsername('');
        $this->assertEquals(null, $userReturn);
    }

    public function testFindByIdSuccess()
    {
        $userModel = new User();
        $userRepository = new UserRepository($userModel);
        $userReturn = $userRepository->findById(1);
        $this->assertEquals(1, $userReturn->getId());
    }

    public function testFindByIdFail()
    {
        $userModel = new User();
        $userRepository = new UserRepository($userModel);
        $userReturn = $userRepository->findById('');
        $this->assertEquals(null, $userReturn);
    }
}
