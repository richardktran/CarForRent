<?php

namespace Khoatran\Tests\App;

use Khoatran\CarForRent\App\DotEnv;
use PHPUnit\Framework\TestCase;

class DotEnvTest extends TestCase
{
    public function testDotEnv()
    {
        (new DotEnv(__DIR__ . '/../../.env'))->load();
        $appName = getenv('APP_NAME');
        $appNameExpected = 'carforrent';
        $this->assertEquals($appNameExpected, $appName);
    }

}
