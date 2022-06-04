<?php

namespace Khoatran\CarForRent\Service\Contracts;

use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Request\LoginRequest;

interface LoginServiceInterface
{
    public function login(LoginRequest $loginRequest): ?UserModel;
}
