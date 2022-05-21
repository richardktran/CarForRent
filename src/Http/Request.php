<?php

namespace Khoatran\CarForRent\Http;

use Khoatran\CarForRent\App\View;

class Request
{
    /**
     * @return string
     */
    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        if (!strpos($path, '?')) {
            return $path;
        }
        return substr($path, 0, strpos($path, '?'));
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getBody(): array
    {
        $body = [];
        foreach ($_POST as $key => $value) {
            $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        $token = $body['token'] ?? '';
        if (!$token || $token !== $_SESSION['token']) {
            View::render('_404');
            exit;
        }
        return $body;
    }
}