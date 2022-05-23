<?php

namespace Khoatran\CarForRent\Service\Contracts;

interface SessionServiceInterface
{
    public function getUserId(): ?int;

    public function setUserId(int $userId): bool;

    public function destroyUser(): bool;

    public function isLogin(): bool;
}
