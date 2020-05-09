<?php

namespace App\Repository;

use App\Entity\Departments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Departments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departments[]    findAll()
 * @method Departments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartmentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departments::class);
    }

    // /**
    //  * @return Departments[] Returns an array of Departments objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Departments
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
