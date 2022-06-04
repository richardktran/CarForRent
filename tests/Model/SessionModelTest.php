<?php

namespace Khoatran\Tests\Model;


use Khoatran\CarForRent\Model\SessionModel;
use PHPUnit\Framework\TestCase;

class SessionModelTest extends TestCase
{
    public function testGetSessId()
    {
        $userModel = new SessionModel();
        $userModel->setSessId('234132jh43jh5j423h');
        $result = $userModel->getSessId();

        $this->assertEquals('234132jh43jh5j423h', $result);
    }

    public function testGetSessData()
    {
        $userModel = new SessionModel();
        $userModel->setSessData('1');
        $result = $userModel->getSessData();

        $this->assertEquals('1', $result);
    }

    public function testGetSessLifetime()
    {
        $userModel = new SessionModel();
        $userModel->setSessLifetime('1');
        $result = $userModel->getSessLifetime();

        $this->assertEquals('1', $result);
    }
}
