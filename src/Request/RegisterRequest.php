<?php

namespace Khoatran\CarForRent\Request;

class RegisterRequest
{
    private string $username;
    private string $password;
    private string $fullName;
    private string $phoneNumber;

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    private string $confirmPassword;


    public function __construct()
    {
        $this->username = '';
        $this->password = '';
        $this->confirmPassword = '';
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    /**
     * @param string $confirmPassword
     */
    public function setConfirmPassword(string $confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
    }

    public function fromArray(array $params): static
    {
        $this->setUsername($params['username']);
        $this->setPassword($params['password']);
        $this->setConfirmPassword($params['confirmPassword']);
        $this->setFullName($params['fullName']);
        $this->setPhoneNumber($params['phoneNumber']);
        return $this;
    }
}
