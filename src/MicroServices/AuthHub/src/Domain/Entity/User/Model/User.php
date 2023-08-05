<?php

namespace App\Domain\Entity\User\Model;

use Doctrine\ORM\Mapping as ORM;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\LastName;
use App\Domain\ValueObject\FirstName;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\Entity\User\ValueObject\UserId;


#[ORM\Entity]
class User
{
    #[ORM\Embedded(columnPrefix: false)]
    private UserId $id;
    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private FirstName $firstName,
        #[ORM\Embedded(columnPrefix: false)]
        private LastName $lastName,
        #[ORM\Embedded(columnPrefix: false)]
        private Email $email,
        #[ORM\Embedded(columnPrefix: false)]
        private HashedPassword $hashedPassword
    ) {

    }
    public function getId(): ?UserId
    {
        return $this->id;
    }
    public function getEmail(): ?Email
    {
        return $this->email;
    }

    public function getFirstName(): ?FirstName
    {
        return $this->firstName;
    }

    public function getLastName(): ?LastName
    {
        return $this->lastName;
    }
    public function getPassword(): ?HashedPassword
    {
        return $this->hashedPassword;
    }


    public function verifyPassword(HashedPassword $hashedPassword, HashedPassword $plainPassword): bool
    {
        return HashedPassword::verifyPassword($hashedPassword->value, $plainPassword->value);
    }
}
