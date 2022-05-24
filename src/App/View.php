<?php

namespace Khoatran\CarForRent\App;

use Exception;

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
            static::redirect($response->getRedirectUrl());
            return;
        }
        $template = $response->getTemplate();
        $data = $response->getData();
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        require __DIR__ . "/../View/Layout/header.php";
        require __DIR__ . "/../View/$template.php";
        require __DIR__ . "/../View/Layout/footer.php";
    }
}
