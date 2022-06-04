<?php

namespace Khoatran\CarForRent\Request;

use Khoatran\CarForRent\Exception\ValidationException;

class LoginRequest
{
    private string $username;
    private string $password;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->formatRequest($this->username);
    }

    /**
     * @param mixed|string $username
     */
    public function setUsername(mixed $username): void
    {
        $this->username = $this->formatRequest($username);
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param mixed|string $password
     */
    public function setPassword(mixed $password): void
    {
        $this->password = $password;
    }

    /**
     * @param $data
     * @return string
     */
    private function formatRequest($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    public function fromArray(array $requestBody): self
    {
        $this->setUsername($requestBody['username']);
        $this->setPassword($requestBody['password']);
        return $this;
    }

    /**
     * @return bool
     * @throws ValidationException
     */
    public function validate(): bool
    {
        if (empty($this->getUsername()) || empty($this->getPassword())) {
            throw new ValidationException("Your username or password is not empty");
        }

        return true;
    }
}
