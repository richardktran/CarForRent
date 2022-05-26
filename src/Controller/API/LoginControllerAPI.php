<?php

namespace Khoatran\CarForRent\Controller\API;

use Exception;
use Khoatran\CarForRent\Exception\ValidationException;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Resources\UserResource;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;

class LoginControllerAPI
{
    protected LoginServiceInterface $loginService;
    protected Request $request;
    protected Response $response;
    protected UserResource $userResource;

    public function __construct(
        Request $request,
        Response $response,
        LoginServiceInterface $loginService,
        UserResource $userResource
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->loginService = $loginService;
        $this->userResource = $userResource;
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
        return $this->response->toJson([
            'data' => $this->userResource->toArray($userLogin),
            'message' => $errorMessage,
        ], Response::HTTP_OK);
    }
}
