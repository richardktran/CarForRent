<?php

namespace Khoatran\CarForRent\Service;

class SessionService
{
    public static string $userIdKey = 'user_id';

    public static function getUserId(): ?int
    {
        if (isset($_SESSION[self::$userIdKey])) {
            return $_SESSION[self::$userIdKey];
        }
        return null;
    }

    public static function setUserId(int $userId): void
    {
        $_SESSION[self::$userIdKey] = $userId;
    }

    public static function destroyUser(): void
    {
        unset($_SESSION[self::$userIdKey]);
    }

    public static function isLogin(): bool
    {
        return self::getUserId() != null;
    }
}
