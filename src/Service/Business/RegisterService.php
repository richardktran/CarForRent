<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\Exception\RegisterException;
use Khoatran\CarForRent\Helpers\Utils;
use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Request\RegisterRequest;

class RegisterService
{
    use Utils;

    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $registerRequest): bool
    {
        $user = new UserModel();
        $user->setUsername($registerRequest->getUsername());
        $user->setPassword($this->hashPassword($registerRequest->getPassword()));
        $user->setPhoneNumber($registerRequest->getPhoneNumber());
        $user->setFullName($registerRequest->getFullName());
        return $this->userRepository->insertUser($user);
    }
}
