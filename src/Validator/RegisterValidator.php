<?php

namespace Khoatran\CarForRent\Validator;

use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\RegisterRequest;

class RegisterValidator extends Validator
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validateUserRegister(RegisterRequest $registerRequest): bool | array
    {
        $existUser = $this->userRepository->findByUsername($registerRequest->getUsername());
        if ($existUser != null) {
            return ['username' => 'Username already exists'];
        }
        $this->name('fullName')->value($registerRequest->getUsername())->required()->max(50);
        $this->name('phoneNumber')->value($registerRequest->getUsername())->required()->max(50);
        $this->name('username')->value($registerRequest->getUsername())->required()->min(3)->max(50);
        $this->name('password')->value($registerRequest->getPassword())->required()->min(6)->max(50);

        $this->name('confirmPassword')->value($registerRequest->getConfirmPassword())->required()->equal($registerRequest->getPassword());
        if ($this->isSuccess()) {
            return [];
        }
        return $this->getErrors();
    }
}
