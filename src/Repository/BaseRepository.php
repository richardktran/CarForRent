<?php

namespace Khoatran\CarForRent\Repository;

use Khoatran\CarForRent\Database\Database;
use PDO;

abstract class BaseRepository
{
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public function setConnection(PDO $connection): self
    {
        $this->connection = $connection;
        return $this;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

}
