<?php

namespace Khoatran\Tests\Model;

use Khoatran\CarForRent\Model\UserModel;
use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetId()
    {
        $userModel = new UserModel();
        $userModel->setId(1);
        $result = $userModel->getId();

        $this->assertEquals(1, $result);
    }

    public function testGetUsername()
    {
        $userModel = new UserModel();
        $userModel->setUsername('admin');
        $result = $userModel->getUsername();

        $this->assertEquals('admin', $result);
    }

    public function testGetPassword()
    {
        $userModel = new UserModel();
        $userModel->setPassword('admin');
        $result = $userModel->getPassword();

        $this->assertEquals('admin', $result);
    }

    public function testGetFullName()
    {
        $userModel = new UserModel();
        $userModel->setFullName('Tran Dang Khoa');
        $result = $userModel->getFullName();

        $this->assertEquals('Tran Dang Khoa', $result);
    }

    public function testGetPhoneNumber()
    {
        $userModel = new UserModel();
        $userModel->setPhoneNumber('0947685343');
        $result = $userModel->getPhoneNumber();

        $this->assertEquals('0947685343', $result);
    }

    public function testGetType()
    {
        $userModel = new UserModel();
        $userModel->setRole(0);
        $result = $userModel->getRole();

        $this->assertEquals(0, $result);
    }

}
