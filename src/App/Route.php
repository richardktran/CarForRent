<?php

namespace Khoatran\CarForRent\App;

use Khoatran\CarForRent\Request\Request;
use Khoatran\CarForRent\Service\ServiceProvider;
use ReflectionException;

class Route
{
    /**
     * @var array
     */
    public static array $routes = [];

    /**
     * @param string $uri
     * @param mixed $callback
     * @param array $middlewares
     * @return void
     */
    public static function get(string $uri, mixed $callback, array $middlewares = []): void
    {
        self::$routes['GET'][$uri] = [$callback, $middlewares];
    }

    /**
     * @param string $uri
     * @param mixed $callback
     * @param array $middlewares
     * @return void
     */
    public static function post(string $uri, mixed $callback, array $middlewares = []): void
    {
        self::$routes['POST'][$uri] = [$callback, $middlewares];
    }
}
