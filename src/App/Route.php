<?php

namespace Khoatran\CarForRent\App;

use Khoatran\CarForRent\Model\UserModel;

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
    public static function get(string $uri, mixed $callback, string $role = UserModel::ROLE_GUEST, array $middlewares = []): void
    {
        self::$routes['GET'][$uri] = [$callback, $role, $middlewares];
    }

    /**
     * @param string $uri
     * @param mixed $callback
     * @param array $middlewares
     * @return void
     */
    public static function post(string $uri, mixed $callback, string $role = UserModel::ROLE_GUEST, array $middlewares = []): void
    {
        self::$routes['POST'][$uri] = [$callback, $role, $middlewares];
    }
}
