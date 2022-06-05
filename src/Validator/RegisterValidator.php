<?php

namespace Khoatran\CarForRent\Validator;

use Khoatran\CarForRent\Request\RegisterRequest;

class RegisterValidator extends Validator
{
    public function validateUserRegister(RegisterRequest $registerRequest): bool|array
    {
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
