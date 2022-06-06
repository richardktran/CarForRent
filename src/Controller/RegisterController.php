<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\RegisterRequest;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;
use Khoatran\CarForRent\Validator\RegisterValidator;

class RegisterController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(
        Request $request,
        Response $response,
        SessionServiceInterface $sessionService,
        UserRepository $userRepository
    ) {
        parent::__construct($request, $response, $sessionService);
        $this->userRepository = $userRepository;
    }


    public function register(RegisterRequest $registerRequest, RegisterValidator $registerValidator): Response
    {
        if ($this->request->isGet()) {
            if ($this->sessionService->isLogin()) {
                return $this->response->redirect('/');
            }

            return $this->response->renderView('register');
        }
        $requestBody = $this->request->getBody();
        $registerRequest->fromArray($requestBody);
        $validateError = $registerValidator->validateUserRegister($registerRequest);
        if (!empty($validateError)) {
            return $this->response->renderView('register', [
                'username' => $registerRequest->getUsername() ?? '',
                'phoneNumber' => $registerRequest->getPhoneNumber() ?? '',
                'fullName' => $registerRequest->getFullName() ?? '',
                'errors' => $validateError,
            ]);
        }
        $this->userRepository->insertUser($registerRequest->toModel());

        return $this->response->redirect('/login');
    }
}
