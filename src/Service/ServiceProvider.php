<?php

namespace Khoatran\CarForRent\Service;

use Khoatran\CarForRent\App\BaseServiceProvider;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;
use Khoatran\CarForRent\Service\Business\LoginService;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->provider->bind(LoginServiceInterface::class, LoginService::class);
    }
}
