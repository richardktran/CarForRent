<?php

namespace Khoatran\CarForRent\Acl;

interface AclInterface
{
    public function checkPermission(string $role): bool;
}
