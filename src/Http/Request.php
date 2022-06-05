<?php

namespace Khoatran\CarForRent\Http;

use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Service\Business\SessionService;

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

    public function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
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
     */
    public function getBody(): array
    {
        $body = [];
        foreach ($_POST as $key => $value) {
            $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $body;
    }

    public function getFile(): array
    {
        $files = [];
        foreach ($_FILES as $key => $value) {
            $files[$key] = $value;
        }
        return $files;
    }

    /**
     * @return mixed
     */
    public function getRequestJsonBody(): mixed
    {
        $data = file_get_contents('php://input');

        return json_decode($data, true);
    }

    private function getHeaderToken(): ?string
    {
        return $_SERVER['HTTP_AUTHORIZATION'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $_SERVER['HTTP_AUTHORIZATION'] ?? null;
    }
}
