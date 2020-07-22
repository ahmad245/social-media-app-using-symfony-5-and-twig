<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    private $userRepository;
    public function __construct(ManagerRegistry $registry, UserRepository $userRepository)
    {
        parent::__construct($registry, Post::class);
        $this->userRepository = $userRepository;
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByUsers($users, $limit = 20, $offset = 1)
    {
        $query= $this->createQueryBuilder('p')
            ->select('p', 'u')
            ->join('p.user', 'u')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.comments', 'c')
            ->leftJoin('c.commentReplies', 'cr')
            ->leftJoin('p.likeBy', 'l')
            ->leftJoin('p.images', 'i')

            ->addSelect('t')
            ->addSelect('c')
            ->addSelect('cr')
            ->addSelect('l')
            ->addSelect('i')

            ->where('u IN (:users)')
            ->setParameter('users', $users)
            ->orderBy('p.createAt', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset);
            $paginator=new Paginator($query,$fetchJoinCollection = true);
            return $paginator;
    }
    public function countByUsers($users)
    {
        return $this->createQueryBuilder('p')
            ->select('count(p)')
            ->join('p.user', 'u')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.comments', 'c')
            ->leftJoin('c.commentReplies', 'cr')
            ->leftJoin('p.likeBy', 'l')
            ->leftJoin('p.images', 'i')
            ->where('u IN (:users)')
            ->setParameter('users', $users)
            ->orderBy('p.createAt', 'DESC')
            
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByUser($user)
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'u')
            ->join('p.user', 'u')
            ->leftJoin('u.following', 'uf')
            ->leftJoin('u.followers', 'ufo')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.comments', 'c')
            ->leftJoin('c.commentReplies', 'cr')
            ->leftJoin('p.likeBy', 'l')
            ->leftJoin('p.images', 'i')

            ->addSelect('t')
            ->addSelect('c')
            ->addSelect('cr')
            ->addSelect('l')
            ->addSelect('i')
            ->addSelect('uf')
            ->addSelect('ufo')

            ->where('u = :user')
            ->setParameter('user', $user)
            ->orderBy('p.createAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findMyPost($user,$limit = 20, $offset = 1)
    {
        $query= $this->createQueryBuilder('p')
            ->select('p', 'u')
            ->join('p.user', 'u')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.comments', 'c')
            ->leftJoin('c.commentReplies', 'cr')
            ->leftJoin('p.likeBy', 'l')
            ->leftJoin('p.images', 'i')


            ->addSelect('t')
            ->addSelect('c')
            ->addSelect('cr')
            ->addSelect('l')
            ->addSelect('i')

            ->where('u = :user')
            ->setParameter('user', $user)
            ->orderBy('p.createAt', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset);
            $paginator=new Paginator($query,$fetchJoinCollection = true);
           
            return $paginator;
    }

    public function findAllPost($limit = 20, $offset = 1)
    {
        $query= $this->createQueryBuilder('p')
            ->select('p', 'u','t','l','i')
           
            ->join('p.user', 'u')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.likeBy', 'l')
            ->leftJoin('p.images', 'i')
            ->orderBy('p.createAt', 'DESC')
            ->getQuery()
            ->setMaxResults($limit)
            ->setFirstResult($offset);
            
            $paginator=new Paginator($query,$fetchJoinCollection = true);
           
            return $paginator;
            
    }
    public function countAllPost()
    {
        return $this->createQueryBuilder('p')
            ->select('count(p)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByTags($tag, $limit = 20, $offset = 1)
    {
        $query= $this->createQueryBuilder('p')
            ->select('p', 'u')
            ->join('p.user', 'u')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.comments', 'c')
            ->leftJoin('c.commentReplies', 'cr')
            ->leftJoin('p.likeBy', 'l')
            ->leftJoin('p.images', 'i')

            ->addSelect('t')
            ->addSelect('c')
            ->addSelect('cr')
            ->addSelect('l')
            ->addSelect('i')

            ->where('t.id = :tag')
            ->setParameter('tag', $tag)
            ->setMaxResults($limit)
            ->setFirstResult($offset);
            // ->getResult();
            
            $paginator=new Paginator($query,$fetchJoinCollection = true);
           
            return $paginator;
    }

    public function findByPost($id)
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'u')
            ->where('p.id = :id')
            ->join('p.user', 'u')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.comments', 'c')

            ->leftJoin('c.commentReplies', 'cr')
            ->leftJoin('p.likeBy', 'l')
            ->leftJoin('p.images', 'i')

            ->addSelect('t')
            ->addSelect('c')
            ->addSelect('cr')
            ->addSelect('l')
            ->addSelect('i')



            ->setParameter('id', $id)
           
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getPostBuLikesMoreThan5()
    {
        $query = $this->createQueryBuilder('p')
            ->select('p', 'count(l)')
            ->join('p.likeBy', 'l')
            ->groupBy('p')
            ->orderBy('count(l)', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
        return $query;
    }

    public function fillter(Search $search, $limit = 20, $offset = 1)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p', 'u', 't', 'c', 'l', 'cr', 'i')
            ->join('p.user', 'u')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.comments', 'c')
            ->leftJoin('c.commentReplies', 'cr')
            ->leftJoin('p.likeBy', 'l')
            ->leftJoin('p.images', 'i');
        if (!empty($search->identity)) {
            $query->andWhere('u.email = :identity')
                ->orWhere('u.firstName = :identity')
                ->orWhere('u.lastName = :identity')
                ->setParameter('identity', $search->identity);
        }
        if (!empty($search->country)) {
            $query->andWhere('u.country = :country')
                ->setParameter('country', $search->country);
        }
        if (!empty($search->phone)) {
            $query->andWhere('u.phone = :phone')
                ->setParameter('country', $search->phone);
        }
        if ($search->maxPosts) {
            $query->andWhere('u IN (:users)')
                ->setParameter('users', $this->userRepository->findByMoreThan15Post());
        }
        if ($search->maxLikes) {
            $query->andWhere('p IN  (:maxLikes)')
                ->setParameter('maxLikes', $this->getPostBuLikesMoreThan5());
        }
         $query->orderBy('p.createAt', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset);
            $paginator=new Paginator($query,$fetchJoinCollection = true);
            return $paginator;
    }

    public function findPostsBbLikedByUser($user,$limit = 20, $offset = 1)
    {
        $query= $this->createQueryBuilder('p')
            ->join('p.user', 'u')

            ->leftJoin('p.tags', 't')
            ->leftJoin('p.comments', 'c')
            ->leftJoin('c.commentReplies', 'cr')
            ->leftJoin('p.likeBy', 'l')
            ->leftJoin('p.images', 'i')
            ->where('l = :user')

            ->addSelect('t')
            ->addSelect('c')
            ->addSelect('cr')
            ->addSelect('l')
            ->addSelect('i')
            ->setParameter('user', $user)
            ->setMaxResults($limit)
            ->setFirstResult($offset);
            
            $paginator=new Paginator($query,$fetchJoinCollection = true);
            return $paginator;
    }
    public function findPostsWhereCommentedByUser($user,$limit = 20, $offset = 1)
    {

        $query= $this->createQueryBuilder('p')
            ->join('p.comments', 'c')
            ->join('p.user', 'u')
            ->where('c.commentedBy = :user')

            ->setParameter('user', $user)
            ->setMaxResults($limit)
            ->setFirstResult($offset);
             
            $paginator=new Paginator($query,$fetchJoinCollection = true);
            return $paginator;
    }

   
   
}
