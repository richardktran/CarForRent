<?php

namespace Khoatran\CarForRent\Repository;

use Khoatran\CarForRent\Database\Database;
use Khoatran\CarForRent\Model\CarModel;
use Khoatran\CarForRent\Model\UserModel;
use PDO;

class CarRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public function getAllCars(): array
    {
        $sql = "SELECT * FROM cars";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll();
        $cars = [];
        foreach ($rows as $row) {
            $car = new CarModel();
            $car->setId($row['id']);
            $car->setName($row['name']);
            $car->setDescription($row['description']);
            $car->setType($row['type']);
            $car->setImage($row['image']);
            $car->setPrice($row['price']);
            $car->setBrand($row['brand']);
            $car->setProductionYear($row['production_year']);
            $car->setOwnerId($row['owner']);
            $cars[] = $car;
        }
        return $cars;
    }
}
