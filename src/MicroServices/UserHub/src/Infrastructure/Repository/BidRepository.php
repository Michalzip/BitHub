<?php

namespace UserService\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use UserService\Domain\Entity\Bid\Model\Bid;
use UserService\Domain\Entity\Bid\Repository\BidRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class BidRepository extends ServiceEntityRepository implements BidRepositoryInterface
{
    private EntityManager $em;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bid::class);
        $this->em = $this->getEntityManager();
    }

    public function saveBid(Bid $user): void
    {
        $this->em->merge($user);
        $this->em->flush();
    }
}
