<?php

namespace Khoatran\CarForRent\Service;

use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Model\SessionModel;
use Khoatran\CarForRent\Repository\SessionRepository;
use Khoatran\CarForRent\Repository\UserRepository;

class SessionService
{
    public static string $userIdKey = 'user_id';

    public static function getUserId(): ?int
    {
//        $sessionId = $_COOKIE[self::$userIdKey] ?? '';
//        $sessionRepository = new SessionRepository(Database::getConnection());
//        $userRepository = new UserRepository(Database::getConnection());
//        $session = $sessionRepository->findById($sessionId);
//
//        return $userRepository->findById($session->getSessData())->getId();
        if (isset($_SESSION[self::$userIdKey])) {
            return $_SESSION[self::$userIdKey];
        }
        return null;
    }

    public static function setUserId(int $userId): void
    {
        $session = new SessionModel();
        $session->setSessID(uniqid());
        $session->setSessData($userId);
        $lifetime = time() + (60 * 60 * 24);
        $session->setSessLifetime($lifetime);

        $sessionRepository = new SessionRepository(Database::getConnection());
        $sessionRepository->save($session);
        setcookie(self::$userIdKey, $session->getSessID(), time() + (60 * 60 * 24), '/');
        $_SESSION[self::$userIdKey] = $userId;
    }

    public static function destroyUser(): void
    {
        $sessionId = $_COOKIE[self::$userIdKey] ?? '';
        $sessionRepository = new SessionRepository(Database::getConnection());
        $sessionRepository->deleteById($sessionId);
        setcookie(self::$userIdKey, '', 1, '/');
        unset($_SESSION[self::$userIdKey]);
    }

    public static function isLogin(): bool
    {
        return self::getUserId() != null;
    }
}
