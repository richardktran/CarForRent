<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\Exception\LoginException;
use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;

class LoginService implements LoginServiceInterface
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws LoginException
     */
    public function login(LoginRequest $loginRequest): UserModel
    {
        $user = $this->userRepository->findByUsername($loginRequest->getUsername());

        if ($user == null) {
            throw new LoginException("Your username or password is not correct");
        }
        $checkPassword = password_verify($loginRequest->getPassword(), $user->getPassword());
        if (!$checkPassword) {
            throw new LoginException("Your username or password is not correct");
        }
        return $user;
    }
}
