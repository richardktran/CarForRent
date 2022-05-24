<?php

namespace Khoatran\CarForRent\Service\Business;

use Khoatran\CarForRent\Database\Database;
use PDO;

class DatabaseService
{
    public static function getConnection(): PDO
    {
        return Database::getConnection();
    }
}
