<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Service\LoginService;
use Khoatran\CarForRent\Service\SessionService;
use PDO;

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
        if (!$loginRequest->validate()) {
            View::render('login', [
                'username' => $loginRequest->getUsername() ?? "",
                'password' => '',
                'error' => 'Your username or password is empty',
            ]);
            return;
        }
        $this->loginService->login($loginRequest);
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
