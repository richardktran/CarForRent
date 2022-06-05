<?php

namespace Khoatran\Tests\Helpers;

use PHPUnit\Framework\TestCase;
use Khoatran\CarForRent\Helpers\Utils;

class UtilsTest extends TestCase
{
    use Utils;

    public function testHashPassword()
    {
        $password = '123456';
        $hash = $this->hashPassword($password);
        $this->assertTrue(password_verify('123456', $hash));
    }
}
