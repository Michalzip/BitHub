<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\LastName;
use App\Domain\ValueObject\FirstName;
use App\Domain\ValueObject\HashedPassword;
use App\Application\Command\SignUp\SignUpCommand;
use App\Infrastructure\Repository\AuthRepository;

#[ORM\Entity(repositoryClass: AuthRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\Column(type: "guid", unique: true)]
    #[ORM\CustomIdGenerator(class: "Ramsey\Uuid\Doctrine\UuidGenerator")]
    private string $id ;

    #[ORM\Column(type: "first_name")]
    private FirstName $firstName;

    #[ORM\Column(type: "last_name")]
    private LastName $lastName;

    #[ORM\Column(type: "email", unique: true)]
    private Email $email;

    #[ORM\Column(type: "hashed_password")]
    private HashedPassword $hashedPassword;


    public static function create(SignUpCommand $credentials): self
    {
        $user = new self();
        $user->setFirstName($credentials->firstName);
        $user->setLastName($credentials->lastName);
        $user->setEmail($credentials->email);
        $user->setHashedPassword($credentials->hashedPassword);

        return $user;
    }

    public function createToken(string $password)
    {
        //TODO : implement
    }

    public function verifyPassword(string $hashedPassword, string $plainPassword): bool
    {
        return HashedPassword::fromString($hashedPassword)->match($plainPassword);
    }

    public function getId(): ?string
    {
        return $this->id;
    }
    public function getEmail(): ?Email
    {
        return $this->email;
    }

    public function setFirstName(FirstName $firstName): void
    {
        $this->firstName = $firstName;
    }


    public function setLastName(LastName $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function setHashedPassword(HashedPassword $hashedPassword): void
    {
        $this->hashedPassword = $hashedPassword;
    }

    public function getPassword(): ?HashedPassword
    {
        return $this->hashedPassword;
    }


}
