<?php

namespace Khoatran\CarForRent\Controller;

use Exception;
use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Exception\LoginException;
use Khoatran\CarForRent\Exception\ValidationException;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Request\LoginRequest;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Service\Business\TokenService;
use Khoatran\CarForRent\Service\Contracts\LoginServiceInterface;
use Khoatran\CarForRent\Service\Contracts\SessionServiceInterface;
use Khoatran\CarForRent\Validator\LoginValidator;
use function PHPUnit\Framework\throwException;

class LoginController extends AbstractController
{
    private LoginServiceInterface $loginService;
    private TokenService $tokenService;

    public function __construct(
        Request                 $request,
        Response                $response,
        LoginServiceInterface   $loginService,
        SessionServiceInterface $sessionService,
        TokenService            $tokenService,
    )
    {
        parent::__construct($request, $response, $sessionService);
        $this->loginService = $loginService;
        $this->tokenService = $tokenService;
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
    public function login(LoginRequest $loginRequest, LoginValidator $loginValidator): Response
    {
        $loginRequest = $loginRequest->fromArray($this->request->getBody());

        $loginValidator = $loginValidator->validateUserLogin($loginRequest);
        if (!empty($loginValidator)) {
            return $this->response->renderView('login', [
                'username' => $loginRequest->getUsername() ?? "",
                'password' => '',
                'error' => $loginValidator,
            ]);
        }
        $userLogin = $this->loginService->login($loginRequest);
        if ($userLogin == null) {
            return $this->response->renderView('login', [
                'username' => $loginRequest->getUsername() ?? "",
                'password' => '',
                'error' => ["incorrect" => "Username or password is incorrect"],
            ]);
        }
        $token = $this->tokenService->generate($userLogin->getId());
        $this->sessionService->setUserToken($token);
        return $this->response->redirect('/');
    }

    /**
     * @return Response
     */
    public function logout(): Response
    {
        $isLogout = $this->sessionService->destroyUser();
        return $this->response->redirect('/');
    }
}
