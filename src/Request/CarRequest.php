<?php

namespace Khoatran\CarForRent\Request;

use Khoatran\CarForRent\Exception\ValidationException;

class CarRequest
{
    private string $name;
    private string $description;
    private string $type;
    private ?string $image;
    private int $price;
    private string $brand;
    private int $productionYear;
    private int $ownerId;


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image ?? "";
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price): void
    {
        if (is_numeric($price)) {
            $this->price = $price;
        } else {
            $this->price = 0;
        }
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return int
     */
    public function getProductionYear(): int
    {
        return $this->productionYear;
    }

    /**
     * @param int $productionYear
     */
    public function setProductionYear($productionYear): void
    {
        if (is_numeric($productionYear)) {
            $this->productionYear = $productionYear;
        } else {
            $this->productionYear = 2022;
        }
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    /**
     * @param int $ownerId
     */
    public function setOwnerId(int $ownerId): void
    {
        $this->ownerId = $ownerId;
    }


    public function fromArray(array $requestBody): self
    {
        $this->setName($requestBody['name']);
        $this->setDescription($requestBody['description']);
        $this->setType($requestBody['type']);
        $this->setImage($requestBody['image'] ?? "");
        $this->setPrice($requestBody['price']);
        $this->setBrand($requestBody['brand']);
        $this->setProductionYear($requestBody['production_year']);
        $this->setOwnerId($requestBody['owner_id']);
        return $this;
    }


}
