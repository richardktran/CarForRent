<?php

namespace Khoatran\CarForRent\Repository;

use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Model\SessionModel;
use PDO;

class SessionRepository
{
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public function save(SessionModel $session): SessionModel|bool
    {
        $statement = $this->connection->prepare("INSERT INTO sessions (sess_id, sess_data, sess_lifetime) VALUES(?, ?, ?)");
        $insertSuccess = $statement->execute([
            $session->getSessID(),
            $session->getSessData(),
            $session->getSessLifetime()
        ]);
        if (!$insertSuccess) {
            return false;
        }
        return $session;
    }

    public function deleteById($sessionID): bool
    {
        $statement = $this->connection->prepare("DELETE FROM sessions WHERE sess_id = '$sessionID' ");
        return $statement->execute();
    }

    public function findById($sessionID): SessionModel
    {
        $statement = $this->connection->prepare("SELECT * FROM sessions WHERE sess_id = '$sessionID' ");
        $statement->execute();

        try {
            $session = new SessionModel();
            if ($row = $statement->fetch()) {
                $session->setSessID($row['sess_id']);
                $session->setSessData($row['sess_data']);
                $session->setSessLifetime($row['sess_lifetime']);
            }
            return $session;
        } finally {
            $statement->closeCursor();
        }
    }
}
