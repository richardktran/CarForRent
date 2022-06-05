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
    private LoginValidator $loginValidator;
    private LoginRequest $loginRequest;

    public function __construct(
        Request                 $request,
        Response                $response,
        LoginServiceInterface   $loginService,
        LoginValidator          $loginValidator,
        SessionServiceInterface $sessionService,
        TokenService            $tokenService,
        LoginRequest            $loginRequest
    )
    {
        parent::__construct($request, $response, $sessionService);
        $this->loginService = $loginService;
        $this->tokenService = $tokenService;
        $this->loginValidator = $loginValidator;
        $this->loginRequest = $loginRequest;
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
        $loginRequest = $this->loginRequest->fromArray($this->request->getBody());
        $errorMessage = [];
        try {
            $loginValidator = $this->loginValidator->validateUserLogin($loginRequest);
            if (empty($loginValidator)) {
                $userLogin = $this->loginService->login($loginRequest);
                if ($userLogin !== null) {
                    $token = $this->tokenService->generate($userLogin->getId());
                    $this->sessionService->setUserToken($token);
                    return $this->response->redirect('/');
                }
                $errorMessage = ["incorrect" => "Username or password is incorrect"];
            } else {
                $errorMessage = $loginValidator;
            }
        } catch (Exception $exception) {
            $errorMessage = ['incorrect' => 'The our system went something wrong!'];
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
        return $this->response->redirect('/');
    }
}
