<?php

namespace Khoatran\CarForRent\Validator;

use Khoatran\CarForRent\Request\LoginRequest;

class LoginValidator extends Validator
{
    /**
     * @param LoginRequest $user
     * @return array|bool
     */
    public function validateUserLogin(LoginRequest $user): array|bool
    {
        $this->name('username')->value($user->getUsername())->min(3)->max(70)->required();
        $this->name('password')->value($user->getPassword())->min(3)->max(255)->required();
        if ($this->isSuccess()) {
            return true;
        }
        return $this->getErrors();
    }
}
