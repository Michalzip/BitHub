<?php

namespace AuctionService\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use AuctionService\Domain\Entity\Auction\Repository\AuctionRepositoryInterface;
use AuctionService\Domain\Entity\Auction\Model\Auction;

class AuctionRepository extends ServiceEntityRepository implements AuctionRepositoryInterface
{
    private EntityManager $em;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auction::class);

        $this->em = $this->getEntityManager();
    }


    public function findAll(): array
    {
        return $this->createQueryBuilder('a')
        ->select('a.id.value', 'a.auctionTitle.value', 'a.currentPrice.value', 'a.startPrice.value', 'a.createdAt.value')
            ->getQuery()
            ->getResult();
    }

    public function getAuctionDetailsById(string $auctionId)
    {
        return $this->em->createQueryBuilder()
        ->select('a.winner.value', 'a.currentPrice.value', 'a.startPrice.value', 'a.createdAt.value', 'a.endedAt.value')
        ->from(Auction::class, 'a')
        ->where('a.id.value = :auctionId')
        ->setParameter('auctionId', $auctionId)
        ->getQuery()
        ->getOneOrNullResult();
    }
    public function findActiveAuctions(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.auctionActive.value = :isActive')
            ->andWhere('a.endedAt.value <= :now')
            ->setParameter('isActive', true)
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    public function findById(string $auctionId): ?Auction
    {
        return $this->findOneBy(['id.value' => $auctionId]);
    }

    public function saveAuction(Auction $auction): void
    {
        $this->em->persist($auction);
        $this->em->flush();
    }
}
