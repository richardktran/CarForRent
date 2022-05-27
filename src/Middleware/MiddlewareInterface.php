<?php

namespace Khoatran\CarForRent\Middleware;

use Khoatran\CarForRent\Http\Response;

interface MiddlewareInterface
{
    public function run(): Response | bool;
}
