<?php

namespace Khoatran\CarForRent\Database;

use Khoatran\CarForRent\App\DotEnv;
use PDO;
use PDOException;

class Database
{
    /**
     * @var PDO
     */
    protected static PDO $connection;

    /**
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (empty(self::$connection)) {
            $db_info = array(
                "db_host" => getenv('DATABASE_HOST'),
                "db_port" => getenv('DATABASE_PORT'),
                "db_user" => getenv('DATABASE_USER'),
                "db_pass" => getenv('DATABASE_PASSWORD'),
                "db_name" => getenv('DATABASE_DB_NAME'),
            );

            try {
                self::$connection = new PDO(
                    "mysql:host=" . $db_info['db_host'] . ';port=' . $db_info['db_port'] . ';dbname=' . $db_info['db_name'],
                    $db_info['db_user'],
                    $db_info['db_pass']
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
                self::$connection->query('SET NAMES utf8');
                self::$connection->query('SET CHARACTER SET utf8');
            } catch (PDOException $error) {
                echo $error->getMessage();
            }
        }

        return self::$connection;
    }
}
