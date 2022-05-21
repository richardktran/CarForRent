<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Exception\LoginException;
use Khoatran\CarForRent\Exception\ValidationException;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Request\Request;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;

class LoginController
{
    protected LoginServiceInterface $loginService;
    protected Request $request;
    protected SessionServiceInterface $sessionService;

    public function __construct(Request $request, LoginServiceInterface $loginService, SessionServiceInterface $sessionService)
    {
        $this->loginService = $loginService;
        $this->request = $request;
        $this->sessionService = $sessionService;
    }

    /**
     * @return void
     */
    public function index(): void
    {
        if ($this->sessionService->isLogin()) {
            View::redirect('/');
            return;
        }
        View::render('login', [
            'username' => '',
            'password' => '',
        ]);
    }

    /**
     * @return void
     */
    public function login(): void
    {
        $loginRequest = new LoginRequest($this->request->getBody());
        try {
            $loginRequest->validate();
            $userLogin = $this->loginService->login($loginRequest);
            $this->sessionService->setUserId($userLogin->getId());
            View::redirect('/');
        } catch (ValidationException|LoginException $error) {
            View::render('login', [
                'username' => $loginRequest->getUsername() ?? "",
                'password' => '',
                'error' => $error->getMessage(),
            ]);
            return;
        }

    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->sessionService->destroyUser();
        View::redirect('/login');
    }
}
