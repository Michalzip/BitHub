<?php

namespace App\Infrastructure\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;

use App\Domain\ValueObject\Email;
use App\Domain\Entity\User\Model\User;

use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Entity\User\Repository\AuthRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class AuthRepository extends ServiceEntityRepository implements AuthRepositoryInterface
{
    private EntityManager $em;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->em = $this->getEntityManager();
    }

    public function findUserByEmail(Email $email): ?User
    {

        return   $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            //assign in User class email property from Email value propery class
            ->where(sprintf('%s.email.value = :email', 'u'))
            ->setParameters(['email' => $email->value])
            ->getQuery()->getOneOrNullResult();




    }


    public function getCredentialsByEmail(Email $email): array
    {

        $qb = $this->em
        ->createQueryBuilder()
        ->select('u')
        ->from(User::class, 'u')
        ->where(sprintf('%s.email.value = :email', 'u'))
        ->setParameter('email', $email->value);

        $user = $qb->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);


        return [
            $user['id.value'],
            $user['email.value'],
            $user['firstName.value'],
            $user['lastName.value']

        ];
    }


    public function saveUser(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

}
