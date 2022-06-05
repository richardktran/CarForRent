<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Request\RegisterRequest;
use Khoatran\CarForRent\Service\Business\RegisterService;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;
use Khoatran\CarForRent\Validator\RegisterValidator;

class RegisterController extends AbstractController
{
    private RegisterService $registerService;

    public function __construct(
        Request                 $request,
        Response                $response,
        SessionServiceInterface $sessionService,
        RegisterService         $registerService
    )
    {
        parent::__construct($request, $response, $sessionService);
        $this->registerService = $registerService;
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
        $this->registerService->register($registerRequest);

        return $this->response->redirect('/login');
    }
}
