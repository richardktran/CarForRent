<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\App\DotEnv;
use Khoatran\CarForRent\Exception\UnauthenticatedException;
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

    public function generate(int $userId): string
    {
        $payload = [
            'sub' => $userId,
            'iat' => time(),
        ];
        return JWT::encode($payload, $this->secretToken, 'HS256');
    }

    public function validateToken($token): array
    {
        $decoded = JWT::decode($token, new Key($this->secretToken, 'HS256'));

        return (array)$decoded;
    }

    /**
     * @param string|null $authorizationToken
     * @return array
     * @throws UnauthenticatedException
     */
    public function getTokenPayload(?string $authorizationToken): array
    {
        if ($authorizationToken === null) {
            throw new UnauthenticatedException();
        }
        $token = str_replace('Bearer ', '', $authorizationToken);
        $payload = $this->validateToken($token);
        if ($payload) {
            return $payload;
        }
        throw new UnauthenticatedException();
    }
}
