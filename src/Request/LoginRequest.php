<?php

namespace Khoatran\CarForRent\Request;

class LoginRequest
{
    private string $username;
    private string $password;

    /**
     * @return mixed|string
     */
    public function getUsername(): mixed
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
     * @return mixed|string
     */
    public function getPassword(): mixed
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


    public function __construct(array $loginRequest)
    {
        $this->setUsername($loginRequest['username']);
        $this->setPassword($loginRequest['password']);
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

    /**
     * @return bool
     */
    public function validate(): bool
    {
        if (empty($this->getUsername()) || empty($this->getPassword())) {
            return false;
        }

        return true;
    }
}
