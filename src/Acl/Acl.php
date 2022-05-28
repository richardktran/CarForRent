<?php

namespace Khoatran\CarForRent\Acl;

use Khoatran\CarForRent\Exception\UnauthenticatedException;
use Khoatran\CarForRent\Exception\UnauthorizedException;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Service\Business\TokenService;

class Acl implements AclInterface
{
    private Request $request;
    private TokenService $tokenService;
    private UserRepository $userRepository;

    public function __construct(Request $request, TokenService $tokenService, UserRepository $userRepository)
    {
        $this->request = $request;
        $this->tokenService = $tokenService;
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $role
     * @return bool
     * @throws UnauthorizedException|UnauthenticatedException
     */
    public function checkPermission(string $role): bool
    {
        try {
            $authorizationToken = $this->request->getHeaderToken();
            if ($authorizationToken == null) {
                throw new UnauthorizedException('You don\'t have permission to access this resource');
            }
            $tokenPayload = $this->tokenService->getTokenPayload($authorizationToken);
            $userId = $tokenPayload['sub'];
            $user = $this->userRepository->findById($userId);
            if ($user->getRole() === $role) {
                return true;
            }
            throw new UnauthorizedException('You don\'t have permission to access this resource');
        } catch (UnauthenticatedException $e) {
            throw $e;
        } catch (UnauthorizedException $e) {
            throw $e;
        }

    }
}
