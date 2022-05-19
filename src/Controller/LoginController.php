<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Exception\ValidationException;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Service\LoginService;
use Khoatran\CarForRent\Service\SessionService;

class LoginController
{
    protected LoginService $loginService;

    public function __construct()
    {
        $this->loginService = new LoginService();
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
        $loginRequest = new LoginRequest($_POST);
        try {
            $loginRequest->validate();
        } catch (ValidationException $error) {
            View::render('login', [
                'username' => $loginRequest->getUsername() ?? "",
                'password' => '',
                'error' => $error->getMessage(),
            ]);
            return;
        }

        try {
            $this->loginService->login($loginRequest);
        } catch (ValidationException $error) {
            View::render('login', [
                'username' => $loginRequest->getUsername(),
                'password' => '',
                'error' => $error->getMessage(),
            ]);
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
