<?php

namespace Khoatran\Tests\Model;

use Khoatran\CarForRent\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetId()
    {
        $userModel = new User();
        $userModel->setId(1);
        $result = $userModel->getId();

        $this->assertEquals(1, $result);
    }

    public function testGetUsername()
    {
        $userModel = new User();
        $userModel->setUsername('admin');
        $result = $userModel->getUsername();

        $this->assertEquals('admin', $result);
    }

    public function testGetPassword()
    {
        $userModel = new User();
        $userModel->setPassword('admin');
        $result = $userModel->getPassword();

        $this->assertEquals('admin', $result);
    }

    public function testGetFullName()
    {
        $userModel = new User();
        $userModel->setFullName('Tran Dang Khoa');
        $result = $userModel->getFullName();

        $this->assertEquals('Tran Dang Khoa', $result);
    }

    public function testGetPhoneNumber()
    {
        $userModel = new User();
        $userModel->setPhoneNumber('0947685343');
        $result = $userModel->getPhoneNumber();

        $this->assertEquals('0947685343', $result);
    }

    public function testGetType()
    {
        $userModel = new User();
        $userModel->setRole(0);
        $result = $userModel->getRole();

        $this->assertEquals(0, $result);
    }

}
