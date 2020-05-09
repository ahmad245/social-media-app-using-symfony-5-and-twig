<?php

namespace App\Repository;

use App\Entity\FollowingNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FollowingNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method FollowingNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method FollowingNotification[]    findAll()
 * @method FollowingNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowingNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FollowingNotification::class);
    }

    // /**
    //  * @return FollowingNotification[] Returns an array of FollowingNotification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FollowingNotification
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
