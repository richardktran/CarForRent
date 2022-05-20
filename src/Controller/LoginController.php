<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Exception\LoginException;
use Khoatran\CarForRent\Exception\ValidationException;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Request\Request;
use Khoatran\CarForRent\Service\LoginService;
use Khoatran\CarForRent\Service\SessionService;

class LoginController
{
    protected LoginService $loginService;
    protected Request $request;

    public function __construct()
    {
        $this->loginService = new LoginService();
        $this->request = new Request();
    }

    /**
     * @return void
     */
    public function index(): void
    {
        if (SessionService::isLogin()) {
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
            $this->loginService->login($loginRequest);
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
        SessionService::destroyUser();
        View::redirect('/login');
    }
}
