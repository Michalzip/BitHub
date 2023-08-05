<?php

namespace UserService\Domain\Entity\User\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use UserService\Domain\Entity\Bid\Model\Bid;
use Doctrine\Common\Collections\ArrayCollection;
use Shared\Infrastructure\Service\Auth\Auth;
use Symfony\Component\Security\Core\User\UserInterface;
use UserService\Domain\Entity\Transaction\Model\Transaction;

#[ORM\Entity]
class User implements UserInterface
{
    #[OneToMany(targetEntity: Bid::class, mappedBy: 'user')]
    private $bids;

    #[OneToMany(targetEntity: Transaction::class, mappedBy: 'user')]
    private $transactions;


    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: "guid", unique: true)]
        private string $id,
        #[ORM\Column(name: 'email')]
        private string  $email,
        #[ORM\Column(name: 'first_name')]
        private string  $firstName,
        #[ORM\Column(name: 'last_name')]
        private string $lastName
    ) {
        $this->bids = new ArrayCollection();
        $this->transactions = new ArrayCollection();

    }



    public static function toModel(Auth $authUser): User
    {

        return new self($authUser->getId(), $authUser->getEmail(), $authUser->getFirstName(), $authUser->getLastName());

    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }


    public function eraseCredentials(): void
    {
        // noop
    }
    public function getBids()
    {
        return $this->bids;
    }


}
