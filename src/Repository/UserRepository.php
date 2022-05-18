<?php

namespace Khoatran\CarForRent\Repository;

use Khoatran\CarForRent\Model\UserModel;
use PDO;

class UserRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findByUsername($username): ?UserModel
    {
        $statement = $this->connection->prepare("SELECT * FROM users WHERE username = ? ");
        $statement->execute([$username]);

        $user = new UserModel();
        if ($row = $statement->fetch()) {
            $user->setId($row['id']);
            $user->setUsername($row['username']);
            $user->setPassword($row['password']);
            $user->setFullName($row['full_name']);
            $user->setPhoneNumber($row['phone_number']);
            $user->setType($row['type']);
            return $user;
        } else {
            return null;
        }
    }
}
