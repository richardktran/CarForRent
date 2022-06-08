<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\App\DotEnv;
use Khoatran\CarForRent\Exception\UnauthenticatedException;
use Khoatran\CarForRent\Model\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService
{
    private string $secretToken;


    public function __construct()
    {
        $this->secretToken = getenv('SECRET_TOKEN');
    }

    /**
     * @return array|false|string
     */
    public function getSecretToken(): bool|array|string
    {
        return $this->secretToken;
    }

    /**
     * @param array|false|string $secretToken
     */
    public function setSecretToken(bool|array|string $secretToken): void
    {
        $this->secretToken = $secretToken;
    }

    public function generate(int $userId): string
    {
        $payload = [
            'sub' => $userId,
            'iat' => time(),
        ];
        return JWT::encode($payload, $this->getSecretToken(), 'HS256');
    }

    /**
     * @throws UnauthenticatedException
     */
    public function validateToken($token): array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->getSecretToken(), 'HS256'));
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
    }
}
