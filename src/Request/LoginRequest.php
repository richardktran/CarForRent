<?php

namespace Khoatran\CarForRent\Request;

class LoginRequest
{
    public string $username;
    public string $password;

    public function __construct(array $loginRequest)
    {
        $this->username = $loginRequest['username'];
        $this->password = $loginRequest['password'];
    }
}
