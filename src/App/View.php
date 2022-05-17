<?php

namespace Khoatran\CarForRent\App;

class View
{
    /**
     * @param string $template
     * @return false|string
     */
    public static function render(string $template): false|string
    {
        return file_get_contents(__DIR__ . "/../View/$template.php");
    }
}
