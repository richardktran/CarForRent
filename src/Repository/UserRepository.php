<?php

namespace Khoatran\CarForRent\Repository;

use Exception;
use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Model\UserModel;
use PDO;

class UserRepository extends BaseRepository
{

    public function findByUsername($username): ?UserModel
    {
        $statement = $this->getConnection()->prepare("SELECT * FROM users WHERE username = ? ");
        $statement->execute([$username]);

        if ($row = $statement->fetch()) {
            $user = new UserModel();
            $user->setId($row['id']);
            $user->setUsername($row['username']);
            $user->setPassword($row['password']);
            $user->setFullName($row['full_name']);
            $user->setPhoneNumber($row['phone_number']);
            $user->setRole($row['role']);
            return $user;
        } else {
            return null;
        }
    }

    public function findById($id): ?UserModel
    {
        $statement = $this->getConnection()->prepare("SELECT * FROM users WHERE id = ? ");
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $user = new UserModel();
                $user->setId($row['id']);
                $user->setUsername($row['username']);
                $user->setPassword($row['password']);
                $user->setFullName($row['full_name']);
                $user->setPhoneNumber($row['phone_number']);
                $user->setRole($row['role']);

                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function insertUser(UserModel $user): bool
    {
        $query = "INSERT INTO users (username, password, full_name, phone_number) VALUES(?, ?, ?, ?)";
        $statement = $this->getConnection()->prepare($query);
        try {
            $statement->execute([
                $user->getUsername(),
                $user->getPassword(),
                $user->getFullName(),
                $user->getPhoneNumber()
            ]);
        } catch (Exception $exception) {
            return false;
        }
        return true;
    }
}
