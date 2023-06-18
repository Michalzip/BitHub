<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Infrastructure\Repository\AuthRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: AuthRepository::class)]
class User implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private int $id ;

    #[ORM\Column(type: "string")]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    private string $firstName;

    #[ORM\Column(type: "string")]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 70)]
    private string $lastName;

    #[ORM\Column(type: "string", unique: true)]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(type: "string")]
    private string $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }


}
