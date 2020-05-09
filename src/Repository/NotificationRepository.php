<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Notification;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    // /**
    //  * @return Notification[] Returns an array of Notification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Notification
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getCountNotification(User $user){
        return $this->createQueryBuilder('n')
                    ->select('count(n)')
                    ->where('n.user = :user')
                    ->andWhere('n.seen = false')
                    ->setParameter('user',$user)
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function updateAllNotificationAssSeen(User $user)
    {
        return $this->createQueryBuilder('n')
                    ->update('App\Entity\Notification','n')
                    ->set('n.seen',true)
                    ->where('n.user = :user')
                    ->setParameter('user',$user)
                    ->getQuery()
                    ->execute();
    }
}
