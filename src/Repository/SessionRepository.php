<?php

namespace Khoatran\CarForRent\Repository;

use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Model\SessionModel;
use PDO;

class SessionRepository extends BaseRepository
{
    public function save(SessionModel $session): SessionModel | bool
    {
        $statement = $this->getConnection()->prepare("INSERT INTO sessions (sess_id, sess_data, sess_lifetime) VALUES(?, ?, ?)");
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
        $statement = $this->getConnection()->prepare("DELETE FROM sessions WHERE sess_id = ? ");
        return $statement->execute([$sessionID]);
    }

    public function findById($sessionID): SessionModel
    {
        $statement = $this->getConnection()->prepare("SELECT * FROM sessions WHERE sess_id = ? ");
        $statement->execute([$sessionID]);

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
