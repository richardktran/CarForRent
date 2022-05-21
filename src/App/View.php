<?php

namespace Khoatran\CarForRent\App;

use Exception;

class View
{
    /**
     * @param string $template
     * @param array|null $data
     * @return void
     * @throws Exception
     */
    public static function render(string $template, array $data = null): void
    {
        // Generate a token to prevent CSRF
        $_SESSION['token'] = bin2hex(random_bytes(35));
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
