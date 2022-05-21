<?php

namespace Khoatran\CarForRent\App;

use Khoatran\CarForRent\request\Request;
use Khoatran\CarForRent\Service\ServiceProvider;
use ReflectionException;

class Application
{
    /**
     * @return void
     * @throws ReflectionException
     */
    public function run(): void
    {
        $request = new Request();
        $provider = new ServiceProvider();
        $container = $provider->getContainer();

        $path = $request->getPath();
        $method = $request->getMethod();
        $response = Route::$routes[$method][$path] ?? false;

        if (!$response) {
            View::render('_404');
        }
        $callback = $response[0];
        $middlewares = $response[1];
        foreach ($middlewares as $middleware) {
            $middlewareHandle = $container->make($middleware);;
            $middlewareHandle->run();
        }
        if (is_string($callback)) {
            View::render($callback);
        }

        if (gettype($callback) == 'object') {
            $callback();
        }

        $currenController = $callback[0];
        $action = $callback[1];
        $controller = $container->make($currenController);
        $controller->{$action}();
    }
}
