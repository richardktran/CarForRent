<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Exception\LoginException;
use Khoatran\CarForRent\Exception\ValidationException;
use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;

class LoginService implements LoginServiceInterface
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @throws LoginException
     */
    public function login(LoginRequest $loginRequest): UserModel
    {
        $user = $this->userRepository->findByUsername($loginRequest->getUsername());
        if ($user == null) {
            throw new LoginException("Your account does not exist");
        }
        if (!password_verify($loginRequest->getPassword(), $user->getPassword())) {
            throw new LoginException("Your password is wrong");
        }
        return $user;
    }
}
