<?php

namespace AuctionService\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use AuctionService\Domain\Entity\AuctionUser\Model\AuctionUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use AuctionService\Domain\Entity\AuctionUser\Repository\AuctionUserRepositoryInterface;

class AuctionUserRepository extends ServiceEntityRepository implements AuctionUserRepositoryInterface
{
    private EntityManager $em;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuctionUser::class);

        $this->em = $this->getEntityManager();
    }


    public function findAuctionUser(string $userId, string $auctionId): ?AuctionUser
    {


        return   $this->em->createQueryBuilder()
        ->select('au')
        ->from(AuctionUser::class, 'au')
        ->leftJoin('au.auction', 'a')
        ->andWhere('a.id.value = :auctionId')
        ->andWhere('au.userId = :userId')
        ->setParameter('auctionId', $auctionId)
        ->setParameter('userId', $userId)
        ->getQuery()->getOneOrNullResult();
    }



    public function getAuctionUsersWithSameAuctionId($auctionId): ?array
    {

        return  $this->em->createQueryBuilder()
            ->select('au')
            ->from(AuctionUser::class, 'au')
            ->where('au.auction = :auctionId')
            ->setParameter('auctionId', $auctionId)
            ->getQuery()
            ->getResult();


    }

    public function findAuctionsByUserId($userId): ?array
    {

        return $this->createQueryBuilder('a')
        ->select('a.id.value')
        ->where('a.userId = :userId')
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getResult();

    }

    public function getUserBidByAuctionId(string $auctionId): array
    {

        return $this->em->createQueryBuilder()
        ->select('au.userId', 'au.bidAmount')
        ->from(AuctionUser::class, 'au')
        ->leftJoin('au.auction', 'a')
        ->andWhere('a.id.value = :auctionId')
        ->setParameter('auctionId', $auctionId)
        ->getQuery()
        ->getResult();
    }

    public function updateBidAmount(AuctionUser $auctionUser, float $newBidAmount): void
    {
        $auctionUser->setBidAmount($newBidAmount);
        $this->em->persist($auctionUser);
        $this->em->flush();
    }

    public function saveAuction(AuctionUser $auctionUser): void
    {
        $this->em->persist($auctionUser);
        $this->em->flush();
    }
}
