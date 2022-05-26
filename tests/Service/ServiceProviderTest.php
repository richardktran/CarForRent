<?php

namespace Khoatran\Tests\Service;

use Khoatran\CarForRent\Service\ServiceProvider;
use PHPUnit\Framework\TestCase;

class ServiceProviderTest extends TestCase
{
    public function testRegister()
    {
        $this->expectNotToPerformAssertions();
        $serviceProvider = new ServiceProvider();
        $serviceProvider->register();
    }
}
