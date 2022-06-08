<?php

namespace Khoatran\CarForRent\Service\Contracts;

use Khoatran\CarForRent\Model\User;
use Khoatran\CarForRent\Request\LoginRequest;

interface LoginServiceInterface
{
    public function login(LoginRequest $loginRequest): ?User;
}
