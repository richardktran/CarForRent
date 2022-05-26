<?php

namespace Khoatran\Tests\App;

use Khoatran\CarForRent\App\Container;
use Khoatran\CarForRent\Controller\LoginController;
use Khoatran\CarForRent\Service\ServiceProvider;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testContainerCanAccessConstructor()
    {
        $provider = new ServiceProvider();
        $provider->register();
        $container = $provider->getContainer();
        $loginController = $container->make(LoginController::class);
        $this->assertInstanceOf(LoginController::class, $loginController);
    }
}
