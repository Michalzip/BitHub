<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Application\Command\SignUp\SignUpCommand;
use App\Domain\Repository\AuthRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class AuthRepository implements AuthRepositoryInterface
{

    public function __construct( private EntityManagerInterface $entityManager,private UserPasswordHasherInterface $passwordHasher)
    {
    }
    
    public function createUser(SignUpCommand $command): ?User
    {
        $user = new User();
        $user->setFirstName($command->getFirstName());
        $user->setLastName($command->getLastName());
        $user->setEmail($command->getEmail());
        $user->setPassword($this->passwordHasher->hashPassword($user, $command->getPassword()));

        return $user;
      
    }

    public function checkUserExistByEmail(string $email): ?User
    {
        return $this->entityManager->createQueryBuilder()
        ->select('u')
        ->from(User::class, 'u')
        ->where('u.email = :email')
        ->setParameters(['email' => $email])
        ->getQuery()->getOneOrNullResult();
    }

    public function saveUser(User $user) : void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
   
}
