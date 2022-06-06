<?php

namespace Khoatran\Tests\App;

use Khoatran\CarForRent\App\Container;
use Khoatran\CarForRent\Controller\LoginController;
use Khoatran\CarForRent\Controller\NotFoundController;
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
        $notFoundController = $container->make(NotFoundController::class);
        $this->assertInstanceOf(NotFoundController::class, $notFoundController);
    }
}
