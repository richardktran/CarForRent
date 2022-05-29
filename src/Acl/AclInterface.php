<?php

namespace Khoatran\CarForRent\Acl;

use Khoatran\CarForRent\Http\Response;

interface AclInterface
{
    public function checkPermission(string $role): bool;
}
