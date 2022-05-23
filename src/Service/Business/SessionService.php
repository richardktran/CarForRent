<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Model\SessionModel;
use Khoatran\CarForRent\Repository\SessionRepository;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;

class SessionService implements SessionServiceInterface
{
    public static string $userIdKey = 'user_id';
    protected SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public function getUserId(): ?int
    {
        $sessionId = $_COOKIE[self::$userIdKey] ?? '';
        $session = $this->sessionRepository->findById($sessionId);
        if ($session->getSessID() == null) {
            return null;
        }
        return $this->userRepository->findById($session->getSessData())->getId();
    }

    public function setUserId(int $userId): bool
    {
        $session = new SessionModel();
        $session->setSessID(uniqid());
        $session->setSessData($userId);
        $lifetime = time() + (60 * 60 * 24);
        $session->setSessLifetime($lifetime);

        $sessionSaved = $this->sessionRepository->save($session);
        if (getType($sessionSaved) == 'boolean' && !$sessionSaved) {
            return false;
        }
        setcookie(self::$userIdKey, $session->getSessID(), $lifetime, '/');
        $_SESSION[self::$userIdKey] = $userId;
        return true;
    }

    public function destroyUser(): bool
    {
        $sessionId = $_COOKIE[self::$userIdKey] ?? '';
        $checkDeleteSession = $this->sessionRepository->deleteById($sessionId);
        if (!$checkDeleteSession) {
            return false;
        }
        setcookie(self::$userIdKey, '', 1, '/');
        unset($_SESSION[self::$userIdKey]);
        return true;
    }

    public function isLogin(): bool
    {
        return $this->getUserId() != null;
    }
}
