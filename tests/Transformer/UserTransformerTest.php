<?php

namespace Khoatran\Tests\Transformer;

use Khoatran\CarForRent\Model\User;
use Khoatran\CarForRent\Transformer\UserTransformer;
use PHPUnit\Framework\TestCase;

class UserTransformerTest extends TestCase
{
    public function testToArray()
    {
        $userTransformer = new UserTransformer();
        $user = $this->getUser();
        $userArray = $userTransformer->toArray($user);
        $this->assertEquals(
            [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'fullName' => $user->getFullName(),
                'phoneNumber' => $user->getPhoneNumber(),
                'role' => $user->getRole(),
            ],
            $userArray
        );

    }

    private function getUser(): User
    {
        $user = new User();
        $user->setId(1);
        $user->setUsername('admin');
        $user->setFullName('Admin User');
        $user->setPhoneNumber('0123456789');
        $user->setRole('ROLE_MEMBER');
        return $user;
    }
}
