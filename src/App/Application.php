<?php

namespace Khoatran\CarForRent\App;

use Exception;
use Khoatran\CarForRent\Acl\Acl;
use Khoatran\CarForRent\Controller\NotFoundController;
use Khoatran\CarForRent\Exception\UnauthenticatedException;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Service\Business\SessionService;
use Khoatran\CarForRent\Service\ServiceProvider;
use ReflectionException;

class Application
{
    const CONTROLLER_INDEX = 0;
    const ROLE_INDEX = 1;
    const MIDDLEWARE_INDEX = 2;
    const CLASS_INDEX = 0;
    const METHOD_INDEX = 1;

    private Request $request;
    private Response $response;
    private ServiceProvider $provider;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->provider = new ServiceProvider();
    }

    /**
     * @return void
     * @throws ReflectionException
     * @throws Exception
     */
    public function run(): void
    {
        (new DotEnv(__DIR__ . '/../../.env'))->load();

        $route = $this->getRoute();


        $aclAccept = $this->runAcl($route);
        if (!$aclAccept) {
            return;
        }

        $middlewareAccept = $this->runMiddlewares($route);
        if (!$middlewareAccept) {
            return;
        }

        if (!$route) {
            $currenController = NotFoundController::class;
            $action = 'index';
        } else {
            $callback = $route[static::CONTROLLER_INDEX];
            $currenController = $callback[static::CLASS_INDEX];
            $action = $callback[static::METHOD_INDEX];
        }

        $container = $this->provider->getContainer();
        $controller = $container->make($currenController);
        $response = $controller->{$action}();
        $isLogin = $controller->isLogin();
        View::display($response, $isLogin);
    }


    private function getRoute(): array|bool
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        return Route::$routes[$method][$path] ?? false;
    }

    private function isAPI(): bool
    {
        $path = $this->request->getPath();
        return str_starts_with($path, '/api');
    }


    /**
     * @param $route
     * @return bool
     * @throws ReflectionException
     */
    private function runMiddlewares(bool|array $route): bool
    {
        $container = $this->provider->getContainer();
        $middlewares = $route ? $route[static::MIDDLEWARE_INDEX] : [];

        foreach ($middlewares as $middleware) {
            $middlewareHandle = $container->make($middleware);
            $isNext = $middlewareHandle->run();
            if (gettype($isNext) == 'boolean') {
                continue;
            }
            $response = $isNext;
            View::display($response);
            return false;
        }
        return true;
    }

    /**
     * @param bool|array $route
     * @return bool
     * @throws ReflectionException
     */
    private function runAcl(bool|array $route): bool
    {
        if (!$route) {
            return true;
        }
        $role = $route[static::ROLE_INDEX];
        if ($role === 'ROLE_GUEST') {
            return true;
        }
        $container = $this->provider->getContainer();
        $acl = $container->make(Acl::class);

        try {
            $aclAccept = $acl->checkPermission($route[static::ROLE_INDEX]);
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $message = $e->getMessage();
            if ($e instanceof UnauthenticatedException) {
                if ($this->isAPI()) {
                    $response = $this->response->toJson(['message' => $message], Response::HTTP_BAD_REQUEST);
                } else {
                    $response = $this->response->redirect('/login');
                }
            } else {
                $response = $this->response->renderView('_403', ['message' => $message], $statusCode);
            }
            View::display($response);
            return false;
        }

        return true;
    }
}
