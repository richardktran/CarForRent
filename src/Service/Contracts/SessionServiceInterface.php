<?php

namespace Khoatran\CarForRent\Service\Contracts;

interface SessionServiceInterface
{
    public function getUserToken(): ?int;

    public function setUserToken(string $token): bool;

    public function destroyUser(): bool;

    public function isLogin(): bool;
}
