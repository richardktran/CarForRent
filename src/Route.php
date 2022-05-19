<?php

namespace Khoatran\CarForRent;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Request\Request;

class Route
{
    /**
     * @var array
     */
    protected static array $routes = [];

    /**
     * @param  $uri
     * @param  $callback
     * @return void
     */
    public static function get($uri, $callback, $middlewares = []): void
    {
        self::$routes['GET'][$uri] = [$callback, $middlewares];
    }

    public static function post($uri, $callback, $middlewares = []): void
    {
        self::$routes['POST'][$uri] = [$callback, $middlewares];
    }

    /**
     * @return mixed
     */
    public static function handle(): mixed
    {
        $request = new Request();
        $path = $request->getPath();
        $method = $request->getMethod();
        $response = self::$routes[$method][$path] ?? false;

        if (!$response) {
            View::render('_404');
            return null;
        }
        $callback = $response[0];
        $middlewares = $response[1];
        foreach ($middlewares as $middleware) {
            $middlewareHandle = new $middleware();
            $middlewareHandle->run();
        }
        if (is_string($callback)) {
            View::render($callback);
            return null;
        }
        return call_user_func($callback);
    }
}
