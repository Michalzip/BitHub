<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Email;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Repository\AuthRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager, private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function findUserByEmail(Email $email): ?User
    {
        return $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameters(['email' => $email->toString()])
            ->getQuery()->getOneOrNullResult();
    }

    public function saveUser(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}
