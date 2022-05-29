<?php

namespace Khoatran\CarForRent\Acl;

use Exception;
use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Exception\UnauthenticatedException;
use Khoatran\CarForRent\Exception\UnauthorizedException;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Service\Business\SessionService;
use Khoatran\CarForRent\Service\Business\TokenService;

class Acl implements AclInterface
{
    private Request $request;
    private Response $response;
    private TokenService $tokenService;
    private SessionService $sessionService;
    private UserRepository $userRepository;

    public function __construct(Request $request, Response $response, TokenService $tokenService, UserRepository $userRepository, SessionService $sessionService)
    {
        $this->request = $request;
        $this->response = $response;
        $this->tokenService = $tokenService;
        $this->userRepository = $userRepository;
        $this->sessionService = $sessionService;
    }

    /**
     * @param string $role
     * @return bool
     * @throws UnauthorizedException|UnauthenticatedException
     */
    public function checkPermission(string $role): bool
    {
        $authorizationToken = $this->request->getToken();
        $sessionToken = $this->sessionService->isLogin();
        if ($authorizationToken == null && !$sessionToken) {
            throw new UnauthenticatedException("You are not authenticated");
        }
        if ($sessionToken) {
            $userId = $this->sessionService->getUserToken();
        } else {
            $tokenPayload = $this->tokenService->getTokenPayload($authorizationToken);
            if (!$tokenPayload) {
                throw new UnauthenticatedException("You are not authenticated");
            }
            $userId = $tokenPayload['sub'];
        }

        $user = $this->userRepository->findById($userId);
        if ($user->getRole() === $role) {
            return true;
        }
        throw new UnauthorizedException("You are not authorized");
    }
}
