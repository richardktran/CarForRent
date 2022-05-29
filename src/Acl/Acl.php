<?php

namespace Khoatran\CarForRent\Acl;

use Exception;
use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Exception\UnauthenticatedException;
use Khoatran\CarForRent\Exception\UnauthorizedException;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Service\Business\TokenService;

class Acl implements AclInterface
{
    private Request $request;
    private Response $response;
    private TokenService $tokenService;
    private UserRepository $userRepository;

    public function __construct(Request $request, Response $response, TokenService $tokenService, UserRepository $userRepository)
    {
        $this->request = $request;
        $this->response = $response;
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
        } catch (Exception $e) {
            return false;
        }
    }
}
