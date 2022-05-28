<?php

namespace Khoatran\CarForRent\App;

use Exception;
use Khoatran\CarForRent\Http\Response;

class View
{
    /**
     * @param $url
     * @return void
     */
    public static function redirect($url): void
    {
        header("location: $url");
    }

    /**
     * @param $response
     * @return void
     */
    public static function display($response): void
    {
        if ($response->getRedirectUrl() !== null) {
            static::handleRedirect($response);
            return;
        }

        if ($response->getTemplate() !== null) {
            static::handleViewTemplate($response);
            return;
        }

        static::handleViewJson($response);

        exit();
    }

    public static function handleViewJson(Response $response)
    {
        $data = $response->getData();
        $statusCode = $response->getStatusCode();
        $dataResponse = json_encode($data);
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);
        print_r($dataResponse);
    }

    public static function handleViewTemplate(Response $response): void
    {
        $template = $response->getTemplate();
        $data = $response->getData();
        http_response_code($response->getStatusCode());
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        require __DIR__ . "/../View/Layout/header.php";
        require __DIR__ . "/../View/$template.php";
        require __DIR__ . "/../View/Layout/footer.php";
    }

    public static function handleRedirect(Response $response): void
    {
        static::redirect($response->getRedirectUrl());
    }
}
