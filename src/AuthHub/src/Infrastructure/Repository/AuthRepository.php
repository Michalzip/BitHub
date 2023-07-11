<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use App\Domain\ValueObject\Email;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Repository\AuthRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class AuthRepository extends ServiceEntityRepository implements AuthRepositoryInterface
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


    public function getCredentialsByEmail(Email $email): array
    {

        $qb = $this->em
        ->createQueryBuilder()
        ->select('u')
        ->from(User::class, 'u')
        ->where('u.email = :email')
        ->setParameter('email', $email->toString());

        $user = $qb->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);

        return [
            $user['id'],
            $user['email'],
            $user['hashedPassword']

        ];
    }


    public function saveUser(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

}
