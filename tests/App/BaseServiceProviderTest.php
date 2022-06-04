<?php

namespace Khoatran\Tests\App;

use Khoatran\CarForRent\App\BaseServiceProvider;
use Khoatran\CarForRent\App\Container;
use PHPUnit\Framework\TestCase;

class BaseServiceProviderTest extends TestCase
{
    public function testItCanBeInstantiated()
    {
        $stub = $this->getMockForAbstractClass(BaseServiceProvider::class);

        $this->assertInstanceOf(Container::class, $stub->getContainer());
    }
}
