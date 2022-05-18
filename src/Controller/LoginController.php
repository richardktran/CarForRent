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
        if (SessionService::getUserId()!=null) {
            View::redirect('/');
            return;
        }
        View::render('login', [
            'username' => '',
            'password' => '',
        ]);
    }

    public function login(): void
    {
        $loginRequest = new LoginRequest($_POST);
        $userRepository = new UserRepository($this->connection);
        $user = $userRepository->findByUsername($loginRequest->username);
        if ($user == null) {
            View::render('login', [
                'username' => $loginRequest->username,
                'password' => '',
                'error' => 'Username does not exist',
            ]);
            return;
        }
        if (!password_verify($loginRequest->password, $user->getPassword())) {
            View::render('login', [
                'username' => $loginRequest->username,
                'password' => '',
                'error' => 'Wrong password',
            ]);
            return;
        }
        SessionService::setUserId($user->getId());
        View::redirect('/');
    }

    public function logout(): void
    {
        SessionService::destroyUser();
        View::redirect('/login');
    }
}
