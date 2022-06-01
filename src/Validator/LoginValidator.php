<?php

namespace Khoatran\CarForRent\Validator;

use Khoatran\CarForRent\Request\LoginRequest;

class LoginValidator
{
    public function validateUserLogin(LoginRequest $user)
    {
        $validator = new Validator();
        $validator->name('username')->value($user->getUsername())->min(3)->max(70)->required();
        $validator->name('password')->value($user->getPassword())->min(3)->max(255)->required();
        if ($validator->isSuccess()) {
            return true;
        } else {
            return $validator->getErrors();
        }
    }
}
