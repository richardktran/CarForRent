<?php

namespace Khoatran\Tests\Service\Business;

use Khoatran\CarForRent\Exception\UnauthenticatedException;
use Khoatran\CarForRent\Service\Business\TokenService;
use PHPUnit\Framework\TestCase;

class TokenServiceTest extends TestCase
{
    public function testGenerateAndValidateToken()
    {
        $tokenService = new TokenService();
        $tokenService->setSecretToken("secret");
        $token = $tokenService->generate(1);
        $expectedToken = $tokenService->validateToken($token);
        $this->assertEquals(1, $expectedToken['sub']);
    }

    public function testTokenWithInvalidSecretKey()
    {
        $tokenService = new TokenService();
        $tokenService->setSecretToken("secret");
        $token = $tokenService->generate(1);
        $tokenService->setSecretToken("secret1");
        $this->ExpectException(UnauthenticatedException::class);
        $expectedToken = $tokenService->validateToken($token);
    }

    public function testGetTokenPayloadFail()
    {
        $tokenService = new TokenService();
        $payload = $tokenService->getTokenPayload(null);
        $this->assertFalse($payload);
    }

    public function testGetTokenPayloadSuccess()
    {
        $tokenService = new TokenService();
        $tokenService->setSecretToken("secret");
        $token = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlhdCI6MTY1NDQ4OTIxOX0._HnSrKT7IYfrlkwimPFXnJSDFgOgrRmLZvfPnbnKw9M";
        $payload = $tokenService->getTokenPayload($token);
        $expectedResult = [
            'sub' => 1,
            'iat' => 1654489219
        ];
        $this->assertEquals($expectedResult, $payload);
    }
}
