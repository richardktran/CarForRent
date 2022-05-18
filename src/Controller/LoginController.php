<?php

namespace Khoatran\CarForRent\Controller;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Model\UserModel;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\LoginRequest;
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
        if (isset($_SESSION['user_id'])) {
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
        if (!password_verify($loginRequest->password, $user->password)) {
            View::render('login', [
                'username' => $loginRequest->username,
                'password' => '',
                'error' => 'Wrong password',
            ]);
            return;
        }
        $_SESSION["user_id"] = $user->id;
        View::redirect('/');
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        View::redirect('/login');
    }
}
