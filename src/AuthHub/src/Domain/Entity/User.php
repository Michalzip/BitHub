<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\ValueObject\Email;
use Domain\ValueObject\Credentials;
use App\Domain\ValueObject\LastName;
use App\Domain\ValueObject\FirstName;
use App\Domain\ValueObject\HashedPassword;
use App\Infrastructure\Repository\AuthRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: AuthRepository::class)]
class User implements PasswordAuthenticatedUserInterface
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


    public static function create(Credentials $credentials): self
    {
        $user = new self();
        $user->setFirstName($credentials->firstName);
        $user->setLastName($credentials->lastName);
        $user->setEmail($credentials->email);
        $user->setHashedPassword($credentials->password);

        return $user;
    }

    public function createNewToken(string $password)
    {
        //TODO : implement
    }

    public function getId(): ?string
    {
        return $this->id;
    }
    public function getEmail(): ?string
    {
        return $this->email->toString();
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

    public function getPassword(): ?string
    {
        return $this->hashedPassword;
    }


}
