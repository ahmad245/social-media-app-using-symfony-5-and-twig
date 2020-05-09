<?php

namespace App\Repository;

use App\Entity\LikeNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LikeNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method LikeNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method LikeNotification[]    findAll()
 * @method LikeNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LikeNotification::class);
    }

    // /**
    //  * @return LikeNotification[] Returns an array of LikeNotification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LikeNotification
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
