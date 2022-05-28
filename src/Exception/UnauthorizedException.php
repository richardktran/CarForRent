<?php

namespace Khoatran\CarForRent\Exception;

use Exception;

class UnauthorizedException extends Exception
{
    public function __construct($message = 'Unauthorized', $code = 403, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
