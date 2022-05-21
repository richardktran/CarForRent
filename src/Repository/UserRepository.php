<?php

namespace Khoatran\CarForRent\Repository;

use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Model\UserModel;
use PDO;

class UserRepository
{
    private PDO $connection;
    private UserModel $user;

    public function __construct(UserModel $user)
    {
        $this->connection = Database::getConnection();
        $this->user = $user;
    }

    public function findByUsername($username): ?UserModel
    {
        $statement = $this->connection->prepare("SELECT * FROM users WHERE username = ? ");
        $statement->execute([$username]);

        if ($row = $statement->fetch()) {
            $this->user->setId($row['id']);
            $this->user->setUsername($row['username']);
            $this->user->setPassword($row['password']);
            $this->user->setFullName($row['full_name']);
            $this->user->setPhoneNumber($row['phone_number']);
            $this->user->setType($row['type']);
            return $this->user;
        } else {
            return null;
        }
    }

    public function findById($id): ?UserModel
    {
        $statement = $this->connection->prepare("SELECT * FROM users WHERE id = ? ");
        $statement->execute([$id]);

        try {
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
        } finally {
            $statement->closeCursor();
        }
    }
}
