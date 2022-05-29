<?php

namespace Khoatran\CarForRent\Exception;

use Exception;

class UnauthorizedException extends Exception
{
    public function __construct($message = 'You don\'t have permission to access on this server', $code = 403, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
