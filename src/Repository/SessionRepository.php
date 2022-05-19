<?php

namespace Khoatran\CarForRent\Repository;

use Khoatran\CarForRent\Model\SessionModel;
use PDO;

class SessionRepository
{
    protected PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(SessionModel $session): SessionModel
    {
        $statement = $this->connection->prepare("INSERT INTO sessions (sess_id, sess_data, sess_lifetime) VALUES(?, ?, ?)");
        $statement->execute([
            $session->getSessID(),
            $session->getSessData(),
            $session->getSessLifetime()
        ]);
        return $session;
    }

    public function deleteById($sessionID): void
    {
        $statement = $this->connection->prepare("DELETE FROM sessions WHERE id = '$sessionID' ");
        $statement->execute();
    }

    public function findById($sessionID): SessionModel
    {
        $statement = $this->connection->prepare("SELECT id, user_id FROM sessions WHERE id = '$sessionID' ");
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
