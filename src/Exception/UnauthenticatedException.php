<?php

namespace Khoatran\CarForRent\Exception;

use Exception;

class UnauthenticatedException extends Exception
{
    public function __construct($message = 'Unauthenticated', $code = 401, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
