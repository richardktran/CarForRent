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

    /**
     * @throws UnauthenticatedException
     */
    public function validateToken($token): array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretToken, 'HS256'));
        } catch (\Exception $e) {
            throw new UnauthenticatedException('Token is invalid');
        }
        return (array)$decoded;
    }

    /**
     * @param string|null $authorizationToken
     * @return array|bool
     * @throws UnauthenticatedException
     */
    public function getTokenPayload(?string $authorizationToken): array|bool
    {
        if ($authorizationToken === null) {
            return false;
        }
        $token = str_replace('Bearer ', '', $authorizationToken);
        $payload = $this->validateToken($token);
        if ($payload) {
            return $payload;
        }
        return false;
    }
}
