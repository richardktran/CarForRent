<?php

namespace Khoatran\CarForRent\Controller;

use Exception;
use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Exception\LoginException;
use Khoatran\CarForRent\Exception\ValidationException;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;

class LoginController extends AbstractController
{
    protected LoginServiceInterface $loginService;
    protected SessionServiceInterface $sessionService;

    public function __construct(Request $request, Response $response, LoginServiceInterface $loginService, SessionServiceInterface $sessionService)
    {
        parent::__construct($request, $response);
        $this->loginService = $loginService;
        $this->sessionService = $sessionService;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        if ($this->sessionService->isLogin()) {
            return $this->response->redirect('/');
        }
        return $this->response->renderView('login', [
            'username' => '',
            'password' => '',
        ]);
    }

    /**
     * @return Response
     */
    public function login(): Response
    {
        $loginRequest = new LoginRequest();
        $loginRequest = $loginRequest->fromArray($this->request->getBody());
        $errorMessage = "";
        try {
            $loginRequest->validate();
            $userLogin = $this->loginService->login($loginRequest);
            if ($userLogin !== null) {
                $this->sessionService->setUserId($userLogin->getId());
                return $this->response->redirect('/');
            }
            $errorMessage = "Username or password is incorrect";
        } catch (Exception $exception) {
            $errorMessage = 'The our system went something wrong!';
        }
        return $this->response->renderView('login', [
            'username' => $loginRequest->getUsername() ?? "",
            'password' => '',
            'error' => $errorMessage,
        ]);
    }

    /**
     * @return Response
     */
    public function logout(): Response
    {
        $isLogout = $this->sessionService->destroyUser();
        if ($isLogout) {
            return $this->response->redirect('/login');
        }
        return $this->response->redirect('/');
    }
}
