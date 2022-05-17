<?php

namespace Khoatran\CarForRent\Controller;

abstract class BaseController
{
    /**
     * @param string $view
     * @return false|string
     */
    public function render(string $view): false | string
    {
        return file_get_contents(__DIR__ . "/../View/$view.php");
    }
}
