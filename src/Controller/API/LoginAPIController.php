<?php

namespace Khoatran\CarForRent\Controller\API;

use Exception;
use Khoatran\CarForRent\Exception\ValidationException;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Service\Business\TokenService;
use Khoatran\CarForRent\Transformer\UserTransformer;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;

class LoginAPIController
{
    protected LoginServiceInterface $loginService;
    protected Request $request;
    protected Response $response;
    protected UserTransformer $userTransformer;
    protected TokenService $tokenService;

    public function __construct(
        Request $request,
        Response $response,
        LoginServiceInterface $loginService,
        UserTransformer $userTransformer,
        TokenService $tokenService
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->loginService = $loginService;
        $this->userTransformer = $userTransformer;
        $this->tokenService = $tokenService;
    }

    public function login(): Response
    {
        $loginRequest = new LoginRequest();
        $loginRequest = $loginRequest->fromArray($this->request->getBody());
        $errorMessage = "";
        try {
            $loginRequest->validate();
        } catch (ValidationException $exception) {
            $errorMessage = $exception->getMessage();
            return $this->response->toJson([
                'message' => $errorMessage,
            ], Response::HTTP_BAD_REQUEST);
        }

        $userLogin = $this->loginService->login($loginRequest);
        if ($userLogin == null) {
            $errorMessage = "Username or password is incorrect";
            return $this->response->toJson([
                'message' => $errorMessage,
            ], Response::HTTP_UNAUTHORIZED);
        }
        $token = $this->tokenService->generate($userLogin);
        return $this->response->toJson([
            'data' => [
                ...$this->userTransformer->toArray($userLogin),
                'token' => $token
            ],
            'message' => $errorMessage,
        ], Response::HTTP_OK);
    }
}
