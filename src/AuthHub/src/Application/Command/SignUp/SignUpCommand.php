<?php

namespace App\Application\Command\SignUp;

class SignUpCommand
{

    public  string $firstName;

    public  $lastName;

    public   $email;
    public  $password;

    public function __construct(string $firstName, string $lastName,  string $email,  string $password)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
}