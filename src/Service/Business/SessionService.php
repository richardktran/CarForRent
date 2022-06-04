<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Exception\UnauthenticatedException;
use Khoatran\CarForRent\Model\SessionModel;
use Khoatran\CarForRent\Repository\SessionRepository;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;

class SessionService implements SessionServiceInterface
{
    public static string $userTokenKey = 'user_token';
    protected SessionRepository $sessionRepository;
    private UserRepository $userRepository;
    private TokenService $tokenService;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository, TokenService $tokenService)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
        $this->tokenService = $tokenService;
    }

    public function getUserToken(): ?int
    {
        $sessionId = $_COOKIE[self::$userTokenKey] ?? '';
        $session = $this->sessionRepository->findById($sessionId);
        if ($session->getSessID() == null) {
            return null;
        }
        $token = $session->getSessData();
        try {
            $payload = $this->tokenService->validateToken($token);
        } catch (UnauthenticatedException $e) {
            return null;
        }
        $userId = $payload['sub'];
        return $this->userRepository->findById($userId)->getId();
    }

    public function setUserToken(string $token): bool
    {
        $session = new SessionModel();
        $session->setSessID(uniqid());
        $session->setSessData($token);
        $lifetime = time() + (60 * 60 * 24);
        $session->setSessLifetime($lifetime);

        $sessionSaved = $this->sessionRepository->save($session);
        if (getType($sessionSaved) == 'boolean' && !$sessionSaved) {
            return false;
        }
        setcookie(self::$userTokenKey, $session->getSessID(), $lifetime, '/');
        $_SESSION[self::$userTokenKey] = $token;
        return true;
    }

    public function destroyUser(): bool
    {
        $sessionId = $_COOKIE[self::$userTokenKey] ?? '';
        $checkDeleteSession = $this->sessionRepository->deleteById($sessionId);
        if (!$checkDeleteSession) {
            return false;
        }
        setcookie(self::$userTokenKey, '', 1, '/');
        unset($_SESSION[self::$userTokenKey]);
        return true;
    }

    public function isLogin(): bool
    {
        return $this->getUserToken() != null;
    }
}
