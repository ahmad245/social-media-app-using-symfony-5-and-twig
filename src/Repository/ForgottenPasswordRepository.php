<?php

namespace App\Repository;

use App\Entity\ForgottenPassword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ForgottenPassword|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForgottenPassword|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForgottenPassword[]    findAll()
 * @method ForgottenPassword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForgottenPasswordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForgottenPassword::class);
    }

    // /**
    //  * @return ForgottenPassword[] Returns an array of ForgottenPassword objects
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
    public function findOneBySomeField($value): ?ForgottenPassword
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
