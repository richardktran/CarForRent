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
use Khoatran\CarForRent\Validator\LoginValidator;

class LoginAPIController extends AbstractAPIController
{
    protected LoginServiceInterface $loginService;
    protected Request $request;
    protected Response $response;
    protected UserTransformer $userTransformer;
    protected TokenService $tokenService;

    public function __construct(
        Request               $request,
        Response              $response,
        LoginServiceInterface $loginService,
        UserTransformer       $userTransformer,
        TokenService          $tokenService,
    )
    {
        parent::__construct($request, $response);
        $this->loginService = $loginService;
        $this->userTransformer = $userTransformer;
        $this->tokenService = $tokenService;
    }

    public function login(LoginRequest $loginRequest, LoginValidator $loginValidator): Response
    {
        $loginRequest = $loginRequest->fromArray($this->request->getRequestJsonBody());
        $loginValidator = $loginValidator->validateUserLogin($loginRequest);
        if (!empty($loginValidator)) {
            return $this->response->toJson([
                'message' => $loginValidator,
            ], Response::HTTP_BAD_REQUEST);
        }

        $userLogin = $this->loginService->login($loginRequest);
        if ($userLogin === null) {
            return $this->response->toJson([
                'message' => "Username or password is incorrect",
            ], Response::HTTP_UNAUTHORIZED);
        }
        $token = $this->tokenService->generate($userLogin->getId());
        return $this->response->toJson([
            'data' => $this->userTransformer->toArray($userLogin),
            'token' => $token,
        ], Response::HTTP_OK);

    }
}
