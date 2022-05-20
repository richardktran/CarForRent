<?php

namespace Khoatran\CarForRent\Service;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Exception\ValidationException;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\LoginRequest;

class LoginService
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $loginRequest): void
    {
        $user = $this->userRepository->findByUsername($loginRequest->getUsername());
        if ($user == null) {
            throw new ValidationException("Your account does not exist");
        }
        if (!password_verify($loginRequest->getPassword(), $user->getPassword())) {
            throw new ValidationException("Your password is wrong");
        }
        SessionService::setUserId($user->getId());
        View::redirect('/');
    }
}
