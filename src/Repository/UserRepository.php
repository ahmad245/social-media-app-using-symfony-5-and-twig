<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findByMoreThan5Post(User $user)
    {
        return $this->createQueryBuilder('u')
                   ->select('u as user,count(up) as postCount')
                   ->join('u.posts','up')
                   ->groupBy('u')
                   ->having('u != :user')
                   ->orderBy('count(up)','DESC')
                   ->setParameter('user',$user)
                   ->setMaxResults(5)
                   ->getQuery()
                   ->getResult();
    }
    public function findByMoreThan5PostButNotFowwing($users,$user)
    {
        return $this->createQueryBuilder('u')
        ->select('u ')
        ->join('u.posts','up')
        ->groupBy('u')
        ->having('u != :user')
        ->andHaving('u NOT IN (:users)')
        ->orderBy('count(up)','DESC')
        ->setParameter('user',$user)
        ->setParameter('users',$users)
        ->setMaxResults(5)
        ->getQuery()
        ->getResult();
    }

    public function findByMoreThan15Post()
    {
        return $this->createQueryBuilder('u')
                   ->select('u as user')
                   ->join('u.posts','up')
                   ->groupBy('u')
                   ->orderBy('count(up)','DESC')
                    ->setMaxResults(5)
                   ->getQuery()
                   ->getResult();
    }

    public function searchByIdentity($user){
           $query=$this->createQueryBuilder('u')
                  ->select('u')
                  ->where('u.email LIKE  :user')
                  ->orWhere('u.firstName LIKE :user')
                   ->orWhere('u.lastName LIKE :user')
                  ->setParameter('user',"%{$user}%");
                  return $query->getQuery()
                                ->getResult();

    }

    public function findBySameCity($users,$city,$user){
       return $this->createQueryBuilder('u')
                   ->select('u')
                    ->where('u NOT IN (:users)')
                    ->andWhere('u.city =:city')
                    ->andWhere('u != :user')
                    ->setParameter('users',$users)
                    ->setParameter('city',$city)
                    ->setParameter('user',$user)
                    ->setMaxResults(5)
                    ->getQuery()
                    ->getResult();
                  
                    

    }


    
}
