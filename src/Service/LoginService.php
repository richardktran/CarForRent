<?php

namespace Khoatran\CarForRent\Service;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Repository\UserRepository;
use Khoatran\CarForRent\Request\LoginRequest;
use PDO;

class LoginService
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository(Database::getConnection());
    }

    public function login(LoginRequest $loginRequest): void
    {
        $user = $this->userRepository->findByUsername($loginRequest->getUsername());
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
}
