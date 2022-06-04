<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\Exception\RegisterException;
use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Request\RegisterRequest;

class RegisterService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $registerRequest): bool
    {
        $existUser = $this->userRepository->findByUsername($registerRequest->getUsername());
        if ($existUser == null) {
            $user = new UserModel();
            $user->setUsername($registerRequest->getUsername());
            $user->setPassword($registerRequest->getPassword());
            $user->setPhoneNumber($registerRequest->getPhoneNumber());
            $user->setFullName($registerRequest->getFullName());
            $this->userRepository->insertUser($user);
            return true;
        }
        throw new RegisterException('Username already exists');
    }
}
