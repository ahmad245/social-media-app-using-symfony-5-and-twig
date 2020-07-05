<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class LikeController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }
   /**
    *  @Route("/like/{id}", name="like")
    *  @Security("is_granted('ROLE_USER') ")
    * @param Post $post
    * @return void
    */
    public function like(Post $post)
    {
        $user=$this->getUser();
        if(!$user){
            return $this->json([
                'code'=>403,
                'message'=>'not authorized'
            ],403);
        }
        $isLiked=$post->isLikedBy($user);
       
        if($isLiked){
            $post->removeLikeBy($user);
            $this->em->flush();
            return $this->json([
                'code'=>200,
                'message'=>'removed',
                'likes'=>count($post->getLikeBy())
                
            ]);
        }
        else{ 
            $post->addLikeBy($user);
            $this->em->flush();
            return $this->json([
                'code'=>200,
                'message'=>'added',
                'likes'=>count($post->getLikeBy())
            ]);
        }
      

    }

   
}
