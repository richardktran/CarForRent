<?php

namespace Khoatran\CarForRent\Service\Contracts;

interface SessionServiceInterface
{
    public function getUserId(): ?int;

    public function setUserId(int $userId): void;

    public function destroyUser(): void;

    public function isLogin(): bool;
}
