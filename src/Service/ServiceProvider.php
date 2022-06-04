<?php

namespace Khoatran\CarForRent\Service;

use Khoatran\CarForRent\App\BaseServiceProvider;
use Khoatran\CarForRent\Service\Business\CarService;
use Khoatran\CarForRent\Service\Business\SessionService;
use Khoatran\CarForRent\Service\Contracts\CarServiceInterface;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;
use Khoatran\CarForRent\Service\Business\LoginService;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->provider->bind(LoginServiceInterface::class, LoginService::class);
        $this->provider->bind(SessionServiceInterface::class, SessionService::class);
        $this->provider->bind(CarServiceInterface::class, CarService::class);
    }
}
