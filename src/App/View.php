<?php

namespace Khoatran\CarForRent\App;

class View
{
    /**
     * @param string $template
     * @param $data
     * @return void
     */
    public static function render(string $template, array $data = null): void
    {
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
