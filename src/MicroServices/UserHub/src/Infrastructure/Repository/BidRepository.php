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

    public function findBid($userId, $auctionId): ?Bid
    {
        return   $this->em->createQueryBuilder()
        ->select('u')
        ->from(Bid::class, 'u')
        ->leftJoin('u.user', 'a')
        ->andWhere('a.id = :userId')
        ->andWhere('u.bidAuctionId.value = :auctionId')
        ->setParameters(['userId' => $userId,'auctionId' => $auctionId])
        ->getQuery()->getOneOrNullResult();
    }

    public function updatePiercedStatus($auctionId)
    {

        $maxBidAmount = $this->createQueryBuilder('b')
            ->select('MAX(b.amount.value)')
            ->where('b.bidAuctionId.value = :auctionId')
            ->setParameter('auctionId', $auctionId)
            ->getQuery()
            ->getSingleScalarResult();

        $this->createQueryBuilder('b')
            ->update()
            ->set('b.pierced.value', 'true')
            ->andWhere('b.amount.value < :maxBidAmount')
            ->andWhere('b.bidAuctionId.value = :auctionId')
            ->setParameter('auctionId', $auctionId)
            ->setParameter('maxBidAmount', $maxBidAmount)
            ->getQuery()
            ->execute();
    }

    public function saveBid(Bid $user): void
    {
        $this->em->merge($user);
        $this->em->flush();
    }
}
