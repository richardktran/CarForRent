<?php

namespace Khoatran\CarForRent\App;

use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Service\ServiceProvider;
use ReflectionException;

class Application
{
    /**
     * @return void
     * @throws ReflectionException
     * @throws \Exception
     */
    public function run($request, $responseView, $provider): void
    {
        $container = $provider->getContainer();

        $path = $request->getPath();
        $method = $request->getMethod();
        $response = Route::$routes[$method][$path] ?? false;

        if (!$response) {
            $responseView->renderView('_404');
            View::display($responseView);
            return;
        }
        $callback = $response[0];
        $middlewares = $response[1];
        foreach ($middlewares as $middleware) {
            $middlewareHandle = $container->make($middleware);
            $isNext = $middlewareHandle->run();
            if (gettype($isNext) == 'boolean') {
                continue;
            }
            View::display($isNext);
        }
        if (is_string($callback)) {
            $responseView->renderView($callback);
        }

        $currenController = $callback[0];
        $action = $callback[1];
        $controller = $container->make($currenController);
        $response = $controller->{$action}();

        View::display($response);
    }
}
