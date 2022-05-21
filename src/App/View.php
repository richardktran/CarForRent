<?php

namespace Khoatran\CarForRent\App;

use Exception;

class View
{
    /**
     * @param string $template
     * @param array|null $data
     * @return void
     */
    public static function render(string $template, array $data = null): void
    {
        // Generate a token to prevent CSRF
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        require __DIR__ . "/../View/Layout/header.php";
        require __DIR__ . "/../View/$template.php";
        require __DIR__ . "/../View/Layout/footer.php";
    }

    /**
     * @param $url
     * @return void
     */
    public static function redirect($url): void
    {
        header("location: $url");
    }
}
