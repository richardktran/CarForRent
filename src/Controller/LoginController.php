<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Service\SessionService;
use PDO;

class LoginController
{
    /**
     * @var PDO
     */
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
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
        $userRepository = new UserRepository($this->connection);
        $user = $userRepository->findByUsername($loginRequest->getUsername());
        if ($user == null) {
            View::render('login', [
                'username' => $loginRequest->getUsername(),
                'password' => '',
                'error' => 'Username does not exist',
            ]);
            return;
        }
        if (!password_verify($loginRequest->getPassword(), $user->getPassword())) {
            View::render('login', [
                'username' => $loginRequest->getUsername(),
                'password' => '',
                'error' => 'Wrong password',
            ]);
            return;
        }
        SessionService::setUserId($user->getId());
        View::redirect('/');
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
