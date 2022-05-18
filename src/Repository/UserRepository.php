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
            $user->id = $row['id'];
            $user->username = $row['username'];
            $user->password = $row['password'];
            $user->fullName = $row['full_name'];
            $user->phoneNumber = $row['phone_number'];
            $user->type = $row['type'];
            return $user;
        } else {
            return null;
        }
    }
}
