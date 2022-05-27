<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\App\DotEnv;
use Khoatran\CarForRent\Model\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService
{
    private string $secretToken;

    public function __construct()
    {
        $this->secretToken = getenv('SECRET_TOKEN');
    }

    public function generate(UserModel $user): string
    {
        $payload = [
            'sub' => $user->getId(),
            'name' => $user->getFullName(),
            'iat' => time(),
        ];
        return JWT::encode($payload, $this->secretToken, 'HS256');
    }
}
