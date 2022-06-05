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
    private RegisterRequest $registerRequest;
    private RegisterValidator $registerValidator;
    private RegisterService $registerService;

    public function __construct(
        Request                 $request,
        Response                $response,
        SessionServiceInterface $sessionService,
        RegisterRequest         $registerRequest,
        RegisterValidator       $registerValidator,
        RegisterService         $registerService
    )
    {
        parent::__construct($request, $response, $sessionService);
        $this->registerRequest = $registerRequest;
        $this->registerValidator = $registerValidator;
        $this->registerService = $registerService;
    }

    public function index(): Response
    {
        if ($this->sessionService->isLogin()) {
            return $this->response->redirect('/');
        }
        return $this->response->renderView('register');
    }

    public function register()
    {
        try {
            $errorMessage = [];
            $requestBody = $this->request->getBody();
            $this->registerRequest->fromArray($requestBody);
            $validateError = $this->registerValidator->validateUserRegister($this->registerRequest);
            if (empty($validateError)) {
                $this->registerService->register($this->registerRequest);
                return $this->response->redirect('/login');
            }
            $errorMessage = $validateError;
        } catch (\Exception $exception) {
            $errorMessage = ['incorrect' => $exception->getMessage()];
        }
        return $this->response->renderView('register', [
            'username' => $this->registerRequest->getUsername() ?? '',
            'phoneNumber' => $this->registerRequest->getPhoneNumber() ?? '',
            'fullName' => $this->registerRequest->getFullName() ?? '',
            'error' => $errorMessage,
        ]);


    }
}
