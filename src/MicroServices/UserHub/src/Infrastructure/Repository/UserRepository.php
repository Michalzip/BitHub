<?php

namespace UserService\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use UserService\Domain\Entity\User\Model\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use UserService\Domain\Entity\User\Repository\UserRepositoryInterface;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    private EntityManager $em;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->em = $this->getEntityManager();
    }

    public function findUserByEmail(string $email): ?User
    {
        return   $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameters(['email' => $email])
            ->getQuery()->getOneOrNullResult();
    }

    public function saveUser(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
